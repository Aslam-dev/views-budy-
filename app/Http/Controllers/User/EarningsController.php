<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Earning;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EarningsController extends Controller
{

    public function earnings()
    {
        $earnings = Earning::where('user_id',Auth::user()->id)->orderBy('id', 'desc')->get();
        return view('user.earnings.index', ['earnings' => $earnings]);
    }

    public function withdrawals()
    {
        $withdrawals = Withdraw::where('user_id',Auth::user()->id)->orderBy('id', 'desc')->get();
        return view('user.earnings.withdrawals', ['withdrawals' => $withdrawals]);
    }

    public function set(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'payout_details' => 'required|string',
        ],[
            'payout_details.required' => 'Payout Details is Required',
            'payout_details.string' => 'Payout Details should be a String'
        ]);

        if ($validator->fails())
        {
            return response()->json([
                 'status' => 400,
                 'messages' => $validator->getMessageBag()
            ]);
        }

        //User
        User::where('id',Auth::user()->id)->update([
            'payout_id' => $request->payout_id,
            'payout_details' => $request->payout_details
        ]);

        return response()->json([
                'status' => 200,
                'messages' => trans('updated_successfully')
        ]);

    }

    public function withdraw(Request $request)
    {

        $amount = $request->amount;

        if (Auth::user()->payout_details === Null)
        {
            return response()->json([
                'status' => 401,
                'messages' => trans('please_set_your_payout_details_in_order_to_withdraw'),
            ]);
        }

        if ($amount < get_setting('min_withdraw'))
        {
            return response()->json([
                'status' => 401,
                'messages' => trans('withdrawal_should_be_more_than_the_minimum'),
            ]);
        }

        if ($amount > Auth::user()->earnings)
        {
            return response()->json([
                'status' => 401,
                'messages' => trans('you_have_less_money_to_withdraw'),
            ]);
        }

        $days = get_setting('days_withdraw');
        $process_date = Carbon::now()->addDays((int) $days);

        $balance = Auth::user()->earnings - $amount;

        //User wallet
        User::where('id',Auth::user()->id)->update([
            'earnings' => $balance
        ]);



        $item = new Withdraw();
        $item->user_id = Auth::user()->id;
        $item->payout_id = Auth::user()->payout_id;
        $item->payout_details = Auth::user()->payout_details;
        $item->amount = $amount;
        $item->status = 0;
        $item->process_date = $process_date;
        if ($item->save()) {

            return response()->json([
                'status' => 200,
                'messages' => get_setting('currency_symbol').$amount . trans('withdrew_successfully'),
            ]);

        }else{

            return response()->json([
                'status' => 401,
                'messages' => trans('error_something_went_wrong'),
            ]);

        }

    }

}
