<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Earning;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        $views = [];
        //Looping through the month array to get count for each month in the provided year

        for($i = 1; $i <= 12; $i++){
            $views[] = Earning::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::today()->startOfMonth()->month($i))
            ->groupBy(DB::raw("Month(created_at)"))
            ->count();
        }

        $views = json_encode(array_values($views), JSON_NUMERIC_CHECK);

        return view('admin.dashboard', ['views' => $views]);
    }

    public function profile()
    {
        return view('admin.profile');
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
            'email' => 'required|string|email|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'same:confirm_password',
        ],[
            'name.required' => 'Category Name is Required',
            'name.string' => 'Category Name should be a String',
            'name.max' => 'Category Name max characters should be 255',
            'email.required' => 'Email is Required',
            'email.string' => 'Email should be a String',
            'email.email' => 'Email should be an Email',
            'email.max:255' => 'Email max characters should be 255',
            'image.image' => 'Image Field should be an Image',
            'image.mimes' => 'Jpeg, Png, Jpg, Gif, Svg are Allowed',
            'image.max' => 'Image max file is 2048',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                 'status' => 400,
                 'messages' => $validator->getMessageBag()
            ]);
        }

        if($request->hasFile('image'))
        {
            if ($request->old_image != 'avatar.jpg') {
                $path = 'public/uploads/users/'.$request->old_image;
                if(File::exists($path)){
                    File::delete($path);
                }
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = md5(microtime()).'.'.$ext;
            $file->move('public/uploads/users/',$filename);
        }else{
            $filename = $request->old_image;
        }

        $item = User::find($request->user_id);
        $item->name = $request->name;
        $item->slug = Str::slug($request->name);
        $item->email = $request->email;
        if ($request->password) {
            $item->password = Hash::make($request->password);
        }
        $item->image = $filename;
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

    public function list_videos()
    {
        $categories = Category::all();
        $videos = Video::orderBy('created_at', 'desc')->get();
        return view('admin.videos.index', ['categories' => $categories, 'videos' => $videos]);
    }

    public function edit_videos(Request $request)
    {
		$id = $request->id;
        $video = Video::find($id);
        $categories = Category::all();
        return view('admin.videos.index', ['categories' => $categories,'video' => $video]);
    }

    public function update_videos(Request $request)
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

        $item = Video::find($request->id);
        $item->category_id = $request->category_id;
        $item->title = $request->title;
        $item->slug = Str::slug($request->title, '-');
        $item->url = $youtube_url;
        $item->video_id = $video_id;
        $item->view_cost = $request->view_cost;
        $item->view_count = $request->view_count;
        $item->hidden = $request->hidden;
        $item->status = $request->status;

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

	public function destroy_videos(Request $request){


        if(get_setting('app_demo') == 'true'){

            return response()->json([
                'status' => trans('feature_disabled_for_demo_mode')
            ]);

        }

        $id = $request->id;
        Video::where('id',$id)->update(['status' => 4, 'hidden' => 2]);

        return response()->json(['status' => trans('deleted_successfully')]);
	}

    public function view_videos(Request $request)
    {
		$id = $request->id;
        $video = Video::find($id);
        return view('admin.videos.index', ['video' => $video]);
    }

    public function viewers()
    {
        return view('admin.videos.viewers');
    }
}
