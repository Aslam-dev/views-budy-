<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Page;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;

class SitemapController extends Controller
{

    public function index()
    {
        return response()->view('front.sitemap.index')->header('Content-Type', 'text/xml');
    }

    public function categories()
    {
        $categories = Category::where('status', 1)->orderBy('updated_at', 'desc')->get();

        return response()->view('front.sitemap.categories', [
            'categories' => $categories,
        ])->header('Content-Type', 'text/xml');
    }
    public function pages()
    {
        $items = Page::where('status', 1)->orderBy('updated_at', 'desc')->get();

        return response()->view('front.sitemap.pages', [
            'items' => $items,
        ])->header('Content-Type', 'text/xml');
    }

    public function videos()
    {
        $items = Video::where('status', 1)->where('hidden', 1)->orderBy('updated_at', 'desc')->get();

        return response()->view('front.sitemap.videos', [
            'items' => $items,
        ])->header('Content-Type', 'text/xml');
    }

    public function users()
    {
        $users = User::orderBy('updated_at', 'desc')->get();

        return response()->view('front.sitemap.users', [
            'users' => $users,
        ])->header('Content-Type', 'text/xml');
    }

    public function robots()
    {
        return response()->view('front.sitemap.robots')->header('Content-Type', 'text');
    }
}
