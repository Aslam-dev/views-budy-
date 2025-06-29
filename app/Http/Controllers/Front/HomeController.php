<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Earning;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    function index() {

        $videos = Video::where('status', 1)->where('hidden', 1)->orderByDesc('created_at')->paginate(30);

        return view('front.index', ['videos' => $videos]);
    }

    public function paginate()
    {
        $videos = Video::where('status', 1)->where('hidden', 1)->orderByDesc('created_at')->paginate(30);
        return view('front.videos', ['videos' => $videos]);
    }

    public function video(Request $request)
    {
        $video = Video::where('video_id', $request->video_id)->first();

        return view('front.video', ['video' => $video]);
    }

    public function earning(Request $request)
    {
       $video_id = $request->id;
       $video = Video::find($video_id);
       $sender_id = $video->user->id;
       $amount = $video->view_cost;

       if ($video->amount < $video->view_cost || $video->amount == 0) {
            return response()->json([
                'status' => 200,
                'messages' => trans('this_video_does_not_have_enough_money')
            ]);
       }

       $expired_at = Carbon::now()->addHours($video->view_count);

       $item = new Earning();
       $item->user_id = Auth::user()->id;
       $item->sender_id = $sender_id;
       $item->video_id = $video_id;
       $item->amount = $amount;
       $item->expired_at = $expired_at;
       $item->save();

       $new_amount = $video->amount - $video->view_cost;

       //Video
       $video->update([
           'amount' => $new_amount
       ]);

        // Add Funds to User
        User::find(Auth::user()->id)->increment('earnings', $video->view_cost);

       return response()->json([
            'status' => 200,
            'messages' => trans('you_have_earned') .  get_setting('currency_symbol').$amount
        ]);
    }

    public function users(Request $request)
    {
        $users = User::orderByDesc('created_at')->paginate(12);

        return view('front.users', ['users' => $users]);
    }

    public function sortUsers(Request $request)
    {
        $sort = $request->get('sort');
        $number = $request->get('number');
        $search_term = $request->get('search_term');

        $users = User::query();

        if ($request->ajax()) {
            $users = $this->filterUsers($users, $sort, $search_term);
        }
        $users = $users->orderByDesc('created_at')->paginate($number);
        return view('front.partials.users', ['users' => $users]);
    }

    protected function filterUsers($users, $sort, $search_term)
    {

        if ($sort == 'all') {
            $users = $users;
        }elseif ($sort == 'recent') {
            $users = $users->whereBetween('created_at', [Carbon::now()->startOfWeek()->format('Y-m-d H:i:s'), Carbon::now()->endOfWeek()->format('Y-m-d H:i:s')]);
        }elseif ($sort == 'creators') {
            $users = $users->where('creator', '1');
        }elseif ($sort == 'users') {
            $users = $users->where('creator', '0');
        }

        if ($search_term != '') {
            $users = $users->where('name', 'like', '%'.$search_term.'%');
        }
        return $users;
    }


    public function user(Request $request)
    {
		$id = $request->id;
		$slug = $request->slug;
        $user = User::where('id',$id)->where('slug', $slug)->first();
        if (!$user) {
            return redirect()->route('home');
        }

        $videos = Video::where('user_id', $user->id)->where('status', 1)->where('hidden', 1)->orderByDesc('created_at')->paginate(12);
        return view('front.user', ['user' => $user, 'videos' => $videos]);
    }

    public function user_paginate(Request $request)
    {
		$id = $request->id;
		$slug = $request->slug;
        $user = User::where('id',$id)->where('slug', $slug)->first();
        if (!$user) {
            return redirect()->route('home');
        }

        $videos = Video::where('user_id', $user->id)->where('status', 1)->where('hidden', 1)->orderByDesc('created_at')->paginate(12);
        return view('front.videos', ['user' => $user, 'videos' => $videos]);
    }

    public function leaderboard()
    {
        $users = User::join("earnings", "earnings.user_id", "=", "users.id")
        ->select("users.id as user_id", "users.name as user_name","users.image as user_image","users.slug as user_slug")
        ->selectRaw("SUM(earnings.amount) as sum_score") // select() doesn't work for aggregate values
        ->groupBy("users.id", "users.name", "users.image", "users.slug")
        ->orderBy('sum_score', 'desc')
        ->get();

        return view('front.leaderboard', ['users' => $users]);
    }

    public function sortLeaderboard(Request $request)
    {

        $number = $request->get('number');
        $search_term = $request->get('search_term');

        $week = User::join("earnings", "earnings.user_id", "=", "users.id")
        ->select("users.id as user_id")
        ->selectRaw("SUM(earnings.amount) as sum_score_week")
        ->whereBetween('earnings.created_at', [Carbon::now()->startOfWeek()->format('Y-m-d H:i:s'), Carbon::now()->endOfWeek()->format('Y-m-d H:i:s')])
        ->groupBy("users.id")
        ->orderBy('sum_score_week', 'desc')
        ->get();

        $total_users = User::join("earnings", "earnings.user_id", "=", "users.id")
        ->select("users.id as user_id", "users.name as user_name","users.image as user_image","users.slug as user_slug")
        ->selectRaw("SUM(earnings.amount) as sum_score") // select() doesn't work for aggregate values
        ->groupBy("users.id", "users.name", "users.image", "users.slug")
        ->orderBy('sum_score', 'desc')
        ->get();

        $users = User::query();

        $users = $users->join("earnings", "earnings.user_id", "=", "users.id")
        ->select("users.id as user_id", "users.name as user_name","users.image as user_image","users.slug as user_slug")
        ->selectRaw("SUM(earnings.amount) as sum_score") // select() doesn't work for aggregate values
        ->groupBy("users.id", "users.name", "users.image", "users.slug")
        ->orderBy('sum_score', 'desc');

        if ($request->ajax()) {
            $users = $this->filterLeaderboard($users, $search_term);
        }

        $users = $users->paginate($number);
        return view('front.partials.leaderboard', ['users' => $users, 'total_users' => $total_users, 'week' => $week]);
    }

    protected function filterLeaderboard($users, $search_term)
    {

        if ($search_term != '') {
            $users = $users->where('users.name', 'like', '%'.$search_term.'%');
        }
        return $users;
    }

    public function categories()
    {
        $categories = Category::where('status', 1)->orderBy('created_at','asc')->get();
        return view('front.categories', ['categories' => $categories]);
    }

    public function category(Request $request)
    {
        $category = Category::where('slug', $request->slug)->first();
        if (!$category) {
            return redirect()->route('home');
        }
        $videos = Video::where('category_id', $category->id)->where('status', 1)->where('hidden', 1)->orderByDesc('created_at')->paginate(12);

        return view('front.category', ['videos' => $videos, 'category' => $category]);
    }

    public function category_paginate(Request $request)
    {
        $category = Category::where('slug', $request->slug)->first();
        if (!$category) {
            return redirect()->route('home');
        }
        $videos = Video::where('category_id', $category->id)->where('status', 1)->where('hidden', 1)->orderByDesc('created_at')->paginate(12);
        return view('front.videos', ['category' => $category, 'videos' => $videos]);
    }

    public function upload(Request $request)
    {
        if (Auth::check()) {

            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = md5(microtime()).'.'.$ext;
            $file->move('public/uploads/trumbowyg/',$filename);

            $url =  URL::asset('public/uploads/trumbowyg/'.$filename);

            return response()->json([
                'status' => 200,
                'url' => $url
            ]);

        }else {

            return response()->json([
                'status' => 400,
                'messages' => 'Please Login to upload'
            ]);
        }
    }

    public function search(Request $request)
    {

        $search_term = $request->get('search_term');
        if ($search_term != '') {
            $users = User::where('name', 'like', '%'.$search_term.'%')->withCount('search_videos')->orderBy('search_videos_count', 'desc')->limit(5)->get();
            $categories = Category::where('name', 'like', '%'.$search_term.'%')->withCount('search_videos')->orderBy('search_videos_count', 'desc')->limit(10)->get();
            $videos = Video::where('title', 'like', '%'.$search_term.'%')->where('status', 1)->where('hidden', 1)->withCount('search_views')->orderBy('search_views_count', 'desc')->limit(6)->get();
        }

        return view('layouts.partials.front.search', ['users' => $users, 'categories' => $categories, 'videos' => $videos]);
    }

    function add() {
        return view('welcome');
    }

}
