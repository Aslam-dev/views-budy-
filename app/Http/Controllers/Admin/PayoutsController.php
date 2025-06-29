<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Payout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PayoutsController extends Controller
{

    public function index()
    {
        $payouts = Payout::all();
        return view('admin.payouts.index', compact('payouts'));

    }

    public function store(Request $request)
    {

        if(get_setting('app_demo') == 'true'){
            return response()->json([
                'status' => 401,
                'messages' => trans('feature_disabled_for_demo_mode')
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'transaction_fee' => 'required|numeric',
        ],[
            'name.required' => 'Name is Required',
            'name.string' => 'Name should be a String',
            'name.max' => 'Name max characters should be 255',
            'transaction_fee.required' => 'Transaction Fee is Required',
            'transaction_fee.numeric' => 'Only numbers are accepted',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                 'status' => 400,
                 'messages' => $validator->getMessageBag()
            ]);
        }

        $item = new Payout();
        $item->name = $request->name;
        $item->transaction_fee = $request->transaction_fee;
        if ($item->save()) {

            return response()->json([
                'status' => 200,
                'messages' => trans('added_successfully')
            ]);

        }
        else{

            return response()->json([
                'status' => 401,
                'messages' => trans('error_something_went_wrong')
            ]);

        }
    }

    public function edit(Request $request)
    {
		$id = $request->id;
		$emp = Payout::find($id);
		return response()->json($emp);
    }

    public function update(Request $request)
    {
        if(get_setting('app_demo') == 'true'){
            return response()->json([
                'status' => 401,
                'messages' => trans('feature_disabled_for_demo_mode')
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'transaction_fee' => 'required|numeric',
        ],[
            'name.required' => 'Name is Required',
            'name.string' => 'Name should be a String',
            'name.max' => 'Name max characters should be 255',
            'transaction_fee.required' => 'Transaction Fee is Required',
            'transaction_fee.numeric' => 'Only numbers are accepted',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                 'status' => 400,
                 'messages' => $validator->getMessageBag()
            ]);
        }

        $item = Payout::find($request->payout_id);
        $item->name = $request->name;
        $item->transaction_fee = $request->transaction_fee;
        if ($item->update()) {

            return response()->json([
                'status' => 200,
                'messages' => trans('updated_successfully')
            ]);
        }
        else{

            return response()->json([
                'status' => 401,
                'messages' => trans('error_something_went_wrong')
            ]);

        }
    }

	public function destroy(Request $request){

        if(get_setting('app_demo') == 'true'){
            return response()->json(['status' => trans('feature_disabled_for_demo_mode')]);
        }
        $id = $request->id;
        $item = Payout::find($id);
        $item->delete();
        return response()->json(['status' => trans('deleted_successfully')]);
	}
}
