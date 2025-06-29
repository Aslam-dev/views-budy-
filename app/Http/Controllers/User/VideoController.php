<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Payment;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    public function list()
    {
        $categories = Category::where('status', '1')->get();
        $videos = Video::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
        return view('user.videos.list', ['categories' => $categories, 'videos' => $videos]);
    }

    public function paginate()
    {
        $categories = Category::where('status', '1')->get();
        $videos = Video::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
        return view('user.videos.paginate', ['categories' => $categories, 'videos' => $videos]);
    }

    public function add()
    {
        $categories = Category::where('status', '1')->get();
        return view('user.videos.add', ['categories' => $categories]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'url' => 'required',
            'view_cost' => 'required|numeric|min:0',
            'view_count' => 'required|numeric|min:0',
            'amount' => 'required|numeric|min:0',
        ],[
            'title.required' => 'Title is Required',
            'title.string' => 'Title should be a String',
            'title.max:255' => 'Title should be max 255 characters',
            'url.required' => 'URL is Required',
            'view_cost.required' => 'View Cost is Required',
            'view_cost.numeric' => 'Only numbers are accepted',
            'view_cost.min:0' => 'Minimum of 0 characters',
            'view_count.required' => 'View Count is Required',
            'view_count.numeric' => 'Only numbers are accepted',
            'view_count.min:0' => 'Minimum of 0 characters',
            'amount.required' => 'Amount is Required',
            'amount.numeric' => 'Only numbers are accepted',
            'amount.min:0' => 'Minimum of 0 characters',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                 'status' => 400,
                 'messages' => $validator->getMessageBag()
            ]);
        }

        $youtube_url = $request->url;
        if (strpos($youtube_url, 'youtu.be/') === false && strpos($youtube_url, 'www.youtube.com/watch') === false) {

            return response()->json([
                'status' => 401,
                'messages' =>  'Invalid YouTube URL'
            ]);

        } else {
            if (strpos($youtube_url, 'youtu.be/') !== false) {
                $video_id = substr(parse_url($youtube_url, PHP_URL_PATH), 1);
                $youtube_url = 'https://www.youtube.com/watch?v=' . $video_id;
            } else if (strpos($youtube_url, 'www.youtube.com/watch') !== false) {
                parse_str(parse_url($youtube_url, PHP_URL_QUERY), $query_params);
                if (isset($query_params['v'])) {
                    $video_id = $query_params['v'];
                    $youtube_url = 'https://www.youtube.com/watch?v=' . $video_id;
                }
            }
        }

        if ($request->amount > Auth::user()->wallet)
        {
            return response()->json([
                'status' => 401,
                'messages' => 'You have less money in your Wallet to add this Video'
            ]);
        }

        $new_amount = Auth::user()->wallet - $request->amount;

        //User wallet
        User::where('id',Auth::user()->id)->update([
            'wallet' => $new_amount
        ]);

        $duration = ytDuration($video_id);


        $item = new Video();
        $item->user_id = Auth::user()->id;
        $item->category_id = $request->category_id;
        $item->title = $request->title;
        $item->slug = Str::slug($request->title, '-');
        $item->url = $youtube_url;
        $item->video_id = $video_id;
        $item->video_duration = $duration;
        $item->view_cost = $request->view_cost;
        $item->view_count = $request->view_count;
        $item->amount = $request->amount;
        $item->amount_original = $request->amount;
        $item->hidden = $request->hidden;
        if (get_setting('new_videos') == 'Moderation') {
            $item->status = '2';
        }

        if ($item->save()) {

            Payment::create([
                'user_id' => Auth::user()->id,
                'video_id' => $item->id,
                'type' => '1', //Payment
                'amount' => $request->amount,
                'status' => '1'
            ]);

            User::where('id',Auth::user()->id)->update([
                'creator' => '1'
            ]);

            return response()->json([
                'status' => 200,
                'messages' => trans('added_successfully')
            ]);

        }else{

            return response()->json([
                'status' => 401,
                'messages' =>  trans('error_something_went_wrong')
            ]);

        }

    }

    public function edit(Request $request)
    {
		$id = $request->id;
        $video = Video::where('id',$id)->where('user_id', Auth::user()->id)->first();
        if (!$video) {
            return redirect()->route('user.videos.list');
        }
        $categories = Category::where('status', '1')->get();

        return view('user.videos.edit', ['categories' => $categories, 'video' => $video]);
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
            'title' => 'required|string|max:255',
            'url' => 'required',
            'view_cost' => 'required|numeric|min:0',
            'view_count' => 'required|numeric|min:0',
            'amount' => 'required|numeric|min:0',
        ],[
            'title.required' => 'Title is Required',
            'title.string' => 'Title should be a String',
            'title.max:255' => 'Title should be max 255 characters',
            'url.required' => 'URL is Required',
            'view_cost.required' => 'View Cost is Required',
            'view_cost.numeric' => 'Only numbers are accepted',
            'view_cost.min:0' => 'Minimum of 0 characters',
            'view_count.required' => 'View Count is Required',
            'view_count.numeric' => 'Only numbers are accepted',
            'view_count.min:0' => 'Minimum of 0 characters',
            'amount.required' => 'Amount is Required',
            'amount.numeric' => 'Only numbers are accepted',
            'amount.min:0' => 'Minimum of 0 characters',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                 'status' => 400,
                 'messages' => $validator->getMessageBag()
            ]);
        }

        $youtube_url = $request->url;
        if (strpos($youtube_url, 'youtu.be/') === false && strpos($youtube_url, 'www.youtube.com/watch') === false) {

            return response()->json([
                'status' => 401,
                'messages' =>  'Invalid YouTube URL'
            ]);

        } else {
            if (strpos($youtube_url, 'youtu.be/') !== false) {
                $video_id = substr(parse_url($youtube_url, PHP_URL_PATH), 1);
                $youtube_url = 'https://www.youtube.com/watch?v=' . $video_id;
            } else if (strpos($youtube_url, 'www.youtube.com/watch') !== false) {
                parse_str(parse_url($youtube_url, PHP_URL_QUERY), $query_params);
                if (isset($query_params['v'])) {
                    $video_id = $query_params['v'];
                    $youtube_url = 'https://www.youtube.com/watch?v=' . $video_id;
                }
            }
        }

        $duration = ytDuration($video_id);

        $item = Video::find($request->id);
        $item->category_id = $request->category_id;
        $item->title = $request->title;
        $item->slug = Str::slug($request->title, '-');
        $item->url = $youtube_url;
        $item->video_id = $video_id;
        $item->video_duration = $duration;
        $item->view_cost = $request->view_cost;
        $item->view_count = $request->view_count;
        $item->hidden = $request->hidden;

        if ($item->update()) {

            return response()->json([
                'status' => 200,
                'messages' => trans('updated_successfully')
            ]);

        }else{

            return response()->json([
                'status' => 401,
                'messages' => trans('error_something_went_wrong')
            ]);

        }

    }

    public function topup(Request $request)
    {
		$id = $request->id;
        $video = Video::where('id',$id)->where('user_id', Auth::user()->id)->first();
        if (!$video) {
            return redirect()->route('user.videos.list');
        }
        return view('user.videos.topup', ['video' => $video]);
    }

    public function topup_post(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'amount' => 'required',
        ],[
            'amount.required' => 'Amount is Required',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                 'status' => 400,
                 'messages' => $validator->getMessageBag()
            ]);
        }

        if ($request->amount > Auth::user()->wallet)
        {
            return response()->json([
                'status' => 401,
                'messages' => 'You have less money in your Wallet to add this Video'
            ]);
        }

        $new_amount = Auth::user()->wallet - $request->amount;

        //User wallet
        User::where('id',Auth::user()->id)->update([
            'wallet' => $new_amount
        ]);

        Payment::create([
            'user_id' => Auth::user()->id,
            'video_id' => $request->id,
            'type' => '2', //Topup
            'amount' => $request->amount,
            'status' => '1'
        ]);

        $item = Video::find($request->id);
        $amount = $item->amount + $request->amount;
        $amount_original = $item->amount_original + $request->amount;
        $item->amount = $amount;
        $item->amount_original = $amount_original;

        if ($item->update()) {

            return response()->json([
                'status' => 200,
                'messages' => trans('updated_successfully')
            ]);

        }else{

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
        Video::where('id',$id)->update(['status' => 4, 'hidden' => 2]);

        return response()->json(['status' => trans('deleted_successfully')]);
	}

    public function view(Request $request)
    {
		$id = $request->id;
        $video = Video::where('id',$id)->where('user_id', Auth::user()->id)->first();
        if (!$video) {
            return redirect()->route('user.videos.list');
        }
        return view('user.videos.view', ['video' => $video]);
    }
}
