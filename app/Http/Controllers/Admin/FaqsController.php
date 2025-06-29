<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FaqsController extends Controller
{
    public function index()
    {
        $faqs = Faq::all();
        return view('admin.faqs.index', compact('faqs'));

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
            'question' => 'required|string',
            'answer' => 'required|string',
            'order' => 'required|integer',
        ],[
            'question.required' => 'Question is Required',
            'question.string' => 'Question should be a String',
            'answer.required' => 'Answer is Required',
            'answer.string' => 'Answer should be a String',
            'order.required' => 'Answer is Required',
            'order.integer' => 'Order should be an Integer',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                 'status' => 400,
                 'messages' => $validator->getMessageBag()
            ]);
        }

        $faq = new Faq();
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->order = $request->order;
        if ($faq->save()) {

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
		$emp = Faq::find($id);
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
            'question' => 'required|string',
            'answer' => 'required|string',
            'order' => 'required|integer',
        ],[
            'question.required' => 'Question is Required',
            'question.string' => 'Question should be a String',
            'answer.required' => 'Answer is Required',
            'answer.string' => 'Answer should be a String',
            'order.required' => 'Answer is Required',
            'order.integer' => 'Order should be an Integer',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                 'status' => 400,
                 'messages' => $validator->getMessageBag()
            ]);
        }

        $faq = Faq::find($request->faq_id);
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->order = $request->order;
        if ($faq->update()) {

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

            return response()->json([
                'status' => trans('feature_disabled_for_demo_mode')
            ]);

        }

        $id = $request->id;
        $faq = Faq::find($id);
        $faq->delete();
        return response()->json(['status' => trans('deleted_successfully')]);
	}
}
