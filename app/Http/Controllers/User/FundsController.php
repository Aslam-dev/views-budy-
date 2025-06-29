<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use EdwardMuss\Rave\Facades\Rave as Flutterwave;
use App\Models\Fund;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Mollie\Laravel\Facades\Mollie;
use Razorpay\Api\Api;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class FundsController extends Controller
{

    public function index()
    {
        $funds = Fund::whereUserId(Auth::user()->id)->orderBy('id', 'desc')->get();
        return view('user.funds.index', ['funds' => $funds]);
    }

    public function invoice($id)
    {
        $fund = Fund::whereId($id)->whereStatus('1')->first();

        if ($fund->user_id != Auth::user()->id) {
            return redirect()->route('user.wallet');
        }


        $totalAmount = ($fund->amount + $fund->transaction_fee);

        return view('user.funds.invoice', [
        'fund' => $fund,
        'totalAmount' => $totalAmount,
        ]);
    }

    public function add_funds(Request $request)
    {

        if($request->amount != ''){

            switch ($request->payment_gateway) {
                case 'PayPal':
                    return $this->payPal($request);
                    break;

                case 'Stripe':
                    return $this->stripe($request);
                    break;

                case 'Razorpay':
                    return $this->razorpay($request);
                    break;

                case 'Paystack':
                    return $this->paystack($request);
                    break;

                case 'Mollie':
                    return $this->mollie($request);
                    break;

                case 'Flutterwave':
                    return $this->flutterwave($request);
                    break;

                case 'Bank':
                    return $this->bank($request);
                    break;
            }

        }else{
            return redirect()->route('user.wallet')->with('error', trans('add_an_amount'));
        }
    }

    protected function paypal($request){

        $urlSuccess = route('paypal.success');
        $urlCancel   = route('user.wallet');

        $feePayPal   = get_setting('paypal_fee');
        $centsPayPal =  get_setting('paypal_fee_cents');

        $amountFixed = number_format($request->amount + ($request->amount * $feePayPal / 100) + $centsPayPal, 2, '.', '');

        try {
            // Init PayPal
            $provider = new PayPalClient();
            $token = $provider->getAccessToken();
            $provider->setAccessToken($token);


            $order = $provider->createOrder([
              "intent"=> "CAPTURE",
              'application_context' =>
                  [
                      'return_url' => $urlSuccess,
                      'cancel_url' => $urlCancel,
                      'shipping_preference' => 'NO_SHIPPING'
                  ],
              "purchase_units"=> [
                   [
                      "amount"=> [
                          "currency_code"=> get_setting('currency_code'),
                          "value"=> $amountFixed,
                          'breakdown' => [
                            'item_total' => [
                              "currency_code"=> get_setting('currency_code'),
                              "value"=> $amountFixed
                            ],
                          ],
                      ],
                       'description' => 'Add Funds '. Auth::user()->name,

                       'items' => [
                         [
                           'name' => 'Add Funds '. Auth::user()->name,
                            'category' => 'DIGITAL_GOODS',
                              'quantity' => '1',
                              'unit_amount' => [
                                "currency_code"=> get_setting('currency_code'),
                                "value" => $amountFixed
                              ],
                         ],
                      ],

                      'custom_id' => http_build_query([
                          'id' => Auth::user()->id,
                          'amount' => $request->amount,
                          'taxes' => '',
                          'type' => 'deposit'
                      ]),
                  ],
              ],
          ]);

          $url = $order['links'][1]['href'];

          return Redirect::to($url);


        } catch (\Exception $e) {

          Log::debug($e);

          return response()->json([
            'errors' => ['error' => $e->getMessage()]
          ]);
        }
    }

    public function paypal_success(Request $request)
    {

      // Init PayPal
      $provider = new PayPalClient();
      $token = $provider->getAccessToken();
      $provider->setAccessToken($token);

      try {
        // Get PaymentOrder using our transaction ID
        $order = $provider->capturePaymentOrder($request->token);
        $fund_id = $order['purchase_units'][0]['payments']['captures'][0]['id'];

        // Parse the custom data parameters
        parse_str($order['purchase_units'][0]['payments']['captures'][0]['custom_id'] ?? null, $data);

        if ($order['status'] && $order['status'] === "COMPLETED") {
          if ($data) {

                // Check outh POST variable and insert in DB
                $verified_fund_id = Fund::where('fund_id', $fund_id)->first();

                  if (!isset($verified_fund_id)) {
                    // Insert Deposit

                    DB::table('funds')->insert([
                        'user_id' => $data['id'],
                        'fund_id' => $fund_id,
                        'gateway' => 'PayPal',
                        'amount' => $data['amount'],
                        'percentage_applied' => get_setting('paypal_fee').'% + '.get_setting('paypal_fee_cents'),
                        'transaction_fee' => number_format(($data['amount'] * get_setting('paypal_fee') / 100) + get_setting('paypal_fee_cents'), 2, '.', ''),
                        'total' => number_format($data['amount'] + ($data['amount'] * get_setting('paypal_fee') / 100) + get_setting('paypal_fee_cents'), 2, '.', ''),
                        'status' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    // Add Funds to User
                    User::find($data['id'])->increment('wallet', $data['amount']);


                  }// <--- Verified Txn ID

                    return redirect()->route('user.wallet')->with('success', get_setting('currency_symbol').$data['amount'] .' '. trans('deposited_successfully'));

          }

          return redirect('/');
        }

      }  catch (\Exception $e) {
        return redirect('/');
      }

    }

    protected function stripe($request)
    {

          $feeStripe   = get_setting('stripe_fee');
          $centsStripe = get_setting('stripe_fee_cents');

          if (get_setting('currency_code') == 'JPY') {
            $amountFixed = round($request->amount + ($request->amount * $feeStripe / 100) + $centsStripe);
          } else {
            $amountFixed = number_format($request->amount + ($request->amount * $feeStripe / 100) + $centsStripe, 2, '.', '');
          }

            $total   = get_setting('currency_code') == 'JPY' ? $amountFixed : ($amountFixed*100);

            $currency_code = get_setting('currency_code');
            $description = 'Add Funds '. Auth::user()->name;

          $stripe = new \Stripe\StripeClient(get_setting('stripe_secret'));

          $checkout = $stripe->checkout->sessions->create([
            'line_items' => [[
              'price_data' => [
                'currency' => $currency_code,
                'product_data' => [
                  'name' => $description,
                ],
                'unit_amount' => $total,
              ],
              'quantity' => 1,
            ]],
            'mode' => 'payment',

                'metadata' => [
                  'user' => Auth::user()->id,
                  'amount' => $total,
                  'taxes' => '',
                  'type' => 'deposit'
                ],

            'payment_method_types' => ['card'],
            'customer_email' => Auth::user()->email,

            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel') . '?session_id={CHECKOUT_SESSION_ID}',
          ]);

          // Insert
          DB::table('funds')->insert([
            'user_id' => Auth::user()->id,
            'fund_id' => $checkout->id,
            'gateway' => 'Stripe',
            'amount' => $request->amount,
            'percentage_applied' => get_setting('stripe_fee').'% + '.get_setting('stripe_fee_cents'),
            'transaction_fee' => number_format(($request->amount * get_setting('stripe_fee') / 100) + get_setting('stripe_fee_cents'), 2, '.', ''),
            'total' => $total,
            'status' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
          ]);

          return Redirect::to($checkout->url);

    }

    public function stripe_success(Request $request)
    {

        $stripe = new \Stripe\StripeClient(get_setting('stripe_secret'));
        $session_id = $request->get('session_id');
        $session = $stripe->checkout->sessions->retrieve($session_id);
        if (!$session) {
            return redirect()->route('user.wallet')->with('error', trans('invalid_session_id'));
        }else{
                $fund = Fund::where('fund_id', $session_id)->first();
                if (!$fund) {
                  return redirect()->route('user.wallet')->with('error', trans('transaction_not_found'));
                }

                $fund->update(['status'=> 1]);

                // Add Funds to User
                User::find(Auth::user()->id)->increment('wallet', $fund->amount);

                return redirect()->route('user.wallet')->with('success', get_setting('currency_symbol').$fund->amount .' '. trans('deposited_successfully'));
        }

    }

    public function stripe_cancel(Request $request)
    {

        $stripe = new \Stripe\StripeClient(get_setting('stripe_secret'));
        $session_id = $request->get('session_id');
        $session = $stripe->checkout->sessions->retrieve($session_id);
        if (!$session) {
            return redirect()->route('user.wallet')->with('error', trans('invalid_session_id'));
        }else{
                Fund::where('fund_id', $session_id)->delete();
                return redirect()->route('user.wallet')->with('success', trans('payment_cancelled'));
        }

    }

    public function razorpay(Request $request){

        $feeStripe   = get_setting('razorpay_fee');
        $centsStripe = get_setting('razorpay_fee_cents');
        $total = number_format($request->amount + ($request->amount * $feeStripe / 100) + $centsStripe, 2, '.', '');

        return view('user.payment.razorpay', ['total' => $total, 'amount' => $request->amount]);
    }

    public function razorpay_payment(Request $request)
    {
       $key = get_setting('razorpay_key');
       $secret = get_setting('razorpay_secret');
       $api = new Api($key, $secret);

       $payment = $api->payment->fetch($request->razorpay_payment_id);

       if($request->has('razorpay_payment_id') && $request->filled('razorpay_payment_id')){
            try {
               $response = $api->payment->fetch($request->razorpay_payment_id)
                            ->capture(['amount' => $payment['amount']]);

            }catch(\Exception $e){
                return $e->getMessage();
            }
       }

       if($response['status'] == 'captured'){
            $total = $payment['amount'] / 100;
            $amount = $request->amount;
            $transaction_fee = number_format(($amount * get_setting('razorpay_fee') / 100) + get_setting('razorpay_fee_cents'), 2, '.', '');

            DB::table('funds')->insert([
                'user_id' => Auth::user()->id,
                'fund_id' => strRandom(),
                'gateway' => 'Razorpay',
                'amount' => $amount,
                'percentage_applied' => get_setting('razorpay_fee').'% + '.get_setting('razorpay_fee_cents'),
                'transaction_fee' => $transaction_fee,
                'total' => $total,
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Add Funds to User
            User::find(Auth::user()->id)->increment('wallet', $amount);

            return redirect()->route('user.wallet')->with('success', get_setting('currency_symbol').$amount .' '. trans('deposited_successfully'));

       }
    }

    public function paystack(Request $request){

        $feeStripe   = get_setting('paystack_fee');
        $centsStripe = get_setting('paystack_fee_cents');
        $total = number_format($request->amount + ($request->amount * $feeStripe / 100) + $centsStripe, 2, '.', '');

        return view('user.payment.paystack', ['total' => $total, 'amount' => $request->amount]);
    }

    public function paystack_payment(Request $request)
    {
        $reference = $request->reference;

        $secret_key = get_setting('paystack_secret');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$secret_key
        ])->get("https://api.paystack.co/transaction/verify/$reference");

        $response_body = json_decode($response);

        if($response_body->status == true){

            $total = $response_body->data->amount / 100;
            $amount = $response_body->data->metadata->custom_fields->value;
            $transaction_fee = number_format(($amount * get_setting('paystack_fee') / 100) + get_setting('paystack_fee_cents'), 2, '.', '');

            DB::table('funds')->insert([
                'user_id' => Auth::user()->id,
                'fund_id' => $response_body->data->reference,
                'gateway' => 'Paystack',
                'amount' => $amount,
                'percentage_applied' => get_setting('paystack_fee').'% + '.get_setting('paystack_fee_cents'),
                'transaction_fee' => $transaction_fee,
                'total' => $total,
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Add Funds to User
            User::find(Auth::user()->id)->increment('wallet', $amount);

            return redirect()->route('user.wallet')->with('success', get_setting('currency_symbol').$amount .' '. trans('deposited_successfully'));

        }else{

            return redirect()->route('user.wallet')->with('error', trans('payment_error'));
        }

    }

    public function mollie(Request $request){

        $feeStripe   = get_setting('mollie_fee');
        $centsStripe = get_setting('mollie_fee_cents');
        $total = number_format($request->amount + ($request->amount * $feeStripe / 100) + $centsStripe, 2, '.', '');

        return view('user.payment.mollie', ['total' => $total, 'amount' => $request->amount]);
    }

    public function mollie_post(Request $request)
    {
        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => "USD",
                "value" => $request->price // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "description" => $request->product_name,
            "redirectUrl" => route('mollie.success'),
            //"webhookUrl" => route('webhooks.mollie'),
            "metadata" => [
                "order_id" => time(),
            ],
        ]);

        session()->put('paymentId', $payment->id);
        session()->put('quantity', $request->quantity);
        session()->put('amount', $request->amount);

        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function mollie_success(Request $request)
    {
        $paymentId = session()->get('paymentId');
        $amount = session()->get('amount');

        $payment = Mollie::api()->payments->get($paymentId);

        if($payment->isPaid())
        {

            $total = $payment->amount->value;
            $amount = $amount;
            $transaction_fee = number_format(($amount * get_setting('mollie_fee') / 100) + get_setting('mollie_fee_cents'), 2, '.', '');

            DB::table('funds')->insert([
                'user_id' => Auth::user()->id,
                'fund_id' => $paymentId,
                'gateway' => 'Mollie',
                'amount' => $amount,
                'percentage_applied' => get_setting('mollie_fee').'% + '.get_setting('mollie_fee_cents'),
                'transaction_fee' => $transaction_fee,
                'total' => $total,
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Add Funds to User
            User::find(Auth::user()->id)->increment('wallet', $amount);

            session()->forget('paymentId');
            session()->forget('quantity');
            session()->forget('amount');

            return redirect()->route('user.wallet')->with('success', get_setting('currency_symbol').$amount .' '. trans('deposited_successfully'));


        } else {
            return redirect()->route('mollie.cancel');
        }
    }

    public function mollie_cancel()
    {
        return redirect()->route('user.wallet')->with('error', trans('payment_cancelled'));
    }

    public function flutterwave(Request $request){

        $feeStripe   = get_setting('flutterwave_fee');
        $centsStripe = get_setting('flutterwave_fee_cents');
        $total = number_format($request->amount + ($request->amount * $feeStripe / 100) + $centsStripe, 2, '.', '');

        return view('user.payment.flutterwave', ['total' => $total, 'amount' => $request->amount]);
    }

    public function flutterwave_post(Request $request)
    {
        $total = $request->total;
        $amount = $request->amount;

      try {

        //This generates a payment reference
        $reference = Flutterwave::generateReference();

        // Enter the details of the payment
        $data = [
          'payment_options' => 'card,banktransfer',
          'amount' => $total,
          'email' => Auth::user()->email,
          'tx_ref' => $reference,
          'currency' => 'NGN',
          'redirect_url' => route('flutterwave.callback'),
          'customer' => [
            'email' => Auth::user()->email,
            "name" => Auth::user()->name
          ],

          "meta" => [
            "user" => Auth::user()->id,
            "amountFinal" => $total,
          ],

          "customizations" => [
            "title" => "{{ trans('add_funds') }}"
          ]
        ];

        $payment = Flutterwave::initializePayment($data);

        if ($payment['status'] !== 'success') {
            return redirect()->route('user.wallet')->with('error', trans('payment_error'));
        }

        session()->put('flu_amount', $amount);

        return redirect($payment['data']['link']);

      } catch (\Exception $e) {
        return redirect()->route('user.wallet')->with('error', $e->getMessage());
      }
    }

    public function flutterwave_callback(Request $request)
    {
      $status = request()->status;
      $amount = session()->get('flu_amount');

      //if payment is successful
      if ($status ==  'successful') {

        $transactionID = Flutterwave::getTransactionIDFromCallback();
        $data = Flutterwave::verifyTransaction($transactionID);

        $total = $data['data']['meta']['amountFinal'];
        $amount = $amount;
        $transaction_fee = number_format(($amount * get_setting('flutterwave_fee') / 100) + get_setting('flutterwave_fee_cents'), 2, '.', '');

        DB::table('funds')->insert([
            'user_id' => Auth::user()->id,
            'fund_id' => $data['data']['tx_ref'],
            'gateway' => 'Flutterwave',
            'amount' => $amount,
            'percentage_applied' => get_setting('flutterwave_fee').'% + '.get_setting('flutterwave_fee_cents'),
            'transaction_fee' => $transaction_fee,
            'total' => $total,
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Add Funds to User
        User::find(Auth::user()->id)->increment('wallet', $amount);

        session()->forget('flu_amount');

        return redirect()->route('user.wallet')->with('success', get_setting('currency_symbol').$amount .' '. trans('deposited_successfully'));

      }else{
        return redirect()->route('user.wallet')->with('error', trans('payment_error'));
      }
    }

    public function bank(Request $request){

        $feeStripe   = get_setting('bank_fee');
        $centsStripe = get_setting('bank_fee_cents');
        $total = number_format($request->amount + ($request->amount * $feeStripe / 100) + $centsStripe, 2, '.', '');

        return view('user.payment.bank', ['total' => $total, 'amount' => $request->amount]);
    }

    public function bank_post(Request $request)
    {
        $total = $request->total;
        $amount = $request->amount;
        $transaction_fee = number_format(($amount * get_setting('flutterwave_fee') / 100) + get_setting('flutterwave_fee_cents'), 2, '.', '');


        if($request->hasFile('bank_img'))
        {
            $file = $request->file('bank_img');
            $ext = $file->getClientOriginalExtension();
            $filename = md5(microtime()).'.'.$ext;
            $file->move('public/uploads/bank/',$filename);
        }else{
            return redirect()->route('user.wallet')->with('error', trans('please_upload_the_bank_receipt'));
        }


        DB::table('funds')->insert([
            'user_id' => Auth::user()->id,
            'fund_id' => $request->bank_code,
            'gateway' => 'Bank Transfer',
            'amount' => $amount,
            'percentage_applied' => get_setting('bank_fee').'% + '.get_setting('bank_fee_cents'),
            'transaction_fee' => $transaction_fee,
            'total' => $total,
            'status' => 2,
            'img' => $filename,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('user.wallet')->with('success', trans('waiting_for_admin_to_approve_the_bank_transaction'));

    }
}
