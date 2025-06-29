<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Earning;
use App\Models\Fund;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function deposits()
    {
        $deposits = Fund::orderBy('created_at', 'desc')->get();
        return view('admin.payments.deposits', ['deposits' => $deposits]);
    }

    public function deposits_view($id)
    {
		$fund = Fund::find($id);
        if ($fund->gateway != 'Bank Transfer') {
            return redirect()->back()->with('error', trans('check_payment_gateway'));
        }
        return view('admin.payments.deposits', ["fund" => $fund]);
    }

	public function deposits_approve(Request $request){

        $id = $request->id;
		$fund = Fund::find($id);

        // Add Funds to User
        User::find($fund->user_id)->increment('wallet', $fund->amount);

        $fund->status = '1';
        $fund->update();
        return response()->json(['status' => trans('payment_approved')]);
	}

	public function deposits_reject(Request $request){

        $id = $request->id;
		$fund = Fund::find($id);
        $fund->status = '3';
        $fund->update();
        return response()->json(['status' => trans('payment_rejected')]);
	}

    public function withdrawals()
    {
        $withdrawals = Withdraw::orderBy('created_at', 'desc')->get();
        return view('admin.payments.withdrawals', ['withdrawals' => $withdrawals]);
    }

	public function paid(Request $request){

        $id = $request->id;

        Withdraw::where('id',$id)->update([
            'status' => 1
        ]);
        $w = Withdraw::where('id',$id)->first();

        return response()->json(['status' => trans('paid_successfully')]);
	}

	public function unpaid(Request $request){

        $id = $request->id;

        Withdraw::where('id',$id)->update([
            'status' => 0
        ]);

        return response()->json(['status' => trans('payment_cancelled_successfully')]);
	}

    public function earnings()
    {
        $earnings = Earning::orderBy('created_at', 'desc')->get();
        return view('admin.payments.earnings', ['earnings' => $earnings]);
    }
}
