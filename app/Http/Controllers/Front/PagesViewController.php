<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Admin\Faq;
use App\Models\Admin\Page;
use Illuminate\Http\Request;

class PagesViewController extends Controller
{

    public function about()
    {
        $page = Page::where('status', 1)->where('slug', 'about')->first();

        return view('front.pages.index', ['page' => $page]);
    }

    public function privacy()
    {
        $page = Page::where('status', 1)->where('slug', 'privacy-policy')->first();

        return view('front.pages.index', ['page' => $page]);
    }

    public function terms()
    {
        $page = Page::where('status', 1)->where('slug', 'terms-and-conditions')->first();

        return view('front.pages.index', ['page' => $page]);
    }

    public function cookie()
    {
        $page = Page::where('status', 1)->where('slug', 'cookie-policy')->first();

        return view('front.pages.index', ['page' => $page]);
    }

    public function faqs()
    {
        $faqs = Faq::orderBy('order', 'asc')->get();

        return view('front.pages.faq', ['faqs' => $faqs]);
    }
}
