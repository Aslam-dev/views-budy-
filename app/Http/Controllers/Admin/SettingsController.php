<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Utility\SettingsUtility;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        if(get_setting('app_demo') == 'true'){
            return redirect()->back()->with('error', trans('feature_disabled_for_demo_mode'));
        }

        $inputs = $request->except(['_token']);

        if(!empty($inputs)){
            foreach ($inputs as $type => $value) {

                if($type == 'logo'){
                    if($request->hasFile('logo'))
                    {
                        $path = 'public/uploads/settings/'.get_setting('logo');
                        if(File::exists($path)){
                            File::delete($path);
                        }
                        $file = $request->file('logo');
                        $ext = $file->getClientOriginalExtension();
                        $filename = md5(microtime()).'.'.$ext;
                        $file->move('public/uploads/settings/',$filename);
                        $value = $filename;
                    }
                    SettingsUtility::save_settings($type,trim($value));
                }

                if($type == 'favicon'){
                    if($request->hasFile('favicon'))
                    {
                        $path = 'public/uploads/settings/'.get_setting('favicon');
                        if(File::exists($path)){
                            File::delete($path);
                        }
                        $file = $request->file('favicon');
                        $ext = $file->getClientOriginalExtension();
                        $filename = md5(microtime()).'.'.$ext;
                        $file->move('public/uploads/settings/',$filename);
                        $value = $filename;
                    }
                    SettingsUtility::save_settings($type,trim($value));
                }

                if($type == 'login_bg'){
                    if($request->hasFile('login_bg'))
                    {
                        $path = 'public/uploads/settings/'.get_setting('login_bg');
                        if(File::exists($path)){
                            File::delete($path);
                        }
                        $file = $request->file('login_bg');
                        $ext = $file->getClientOriginalExtension();
                        $filename = md5(microtime()).'.'.$ext;
                        $file->move('public/uploads/settings/',$filename);
                        $value = $filename;
                    }
                    SettingsUtility::save_settings($type,trim($value));
                }

                SettingsUtility::save_settings($type,trim($value));

                if($type == 'timezone'){
                    overWriteEnvFile('APP_TIMEZONE',trim($value));
                }
            }
        }

        return redirect()->back()->with('success', trans('updated_successfully'));
    }

    public function video()
    {
        return view('admin.settings.index');
    }

    public function video_post(Request $request)
    {
        if(get_setting('app_demo') == 'true'){
            return redirect()->back()->with('error', trans('feature_disabled_for_demo_mode'));
        }

        $inputs = $request->except(['_token']);

        if(!empty($inputs)){
            foreach ($inputs as $type => $value) {

                SettingsUtility::save_settings($type,trim($value));

            }
        }

        return redirect()->back()->with('success', trans('updated_successfully'));
    }

    public function home()
    {
        return view('admin.settings.index');
    }

    public function home_post(Request $request)
    {

        if(get_setting('app_demo') == 'true'){
            return redirect()->back()->with('error', trans('feature_disabled_for_demo_mode'));
        }

        $inputs = $request->except(['_token']);

        if(!empty($inputs)){
            foreach ($inputs as $type => $value) {

                if($type == 'home_bg'){
                    if($request->hasFile('home_bg'))
                    {
                        $path = 'public/uploads/settings/'.get_setting('home_bg');
                        if(File::exists($path)){
                            File::delete($path);
                        }
                        $file = $request->file('home_bg');
                        $ext = $file->getClientOriginalExtension();
                        $filename = time().'.'.$ext;
                        $file->move('public/uploads/settings/',$filename);
                        $value = $filename;
                    }
                    SettingsUtility::save_settings($type,trim($value));
                }

                SettingsUtility::save_settings($type,trim($value));

                if($type == 'dates_language'){
                    overWriteEnvFile('DATE_LANGUAGE',trim($value));
                }

            }
        }

        return redirect()->back()->with('success', trans('updated_successfully'));
    }

    public function currency()
    {
        return view('admin.settings.index');
    }

    public function currency_post(Request $request)
    {
        if(get_setting('app_demo') == 'true'){
            return redirect()->back()->with('error', trans('feature_disabled_for_demo_mode'));
        }

        $inputs = $request->except(['_token']);

        if(!empty($inputs)){
            foreach ($inputs as $type => $value) {

                if($type == 'currency_code'){
                    overWriteEnvFile('CURRENCY_CODE',trim($value));
                }

                if($type == 'currency_symbol'){
                    overWriteEnvFile('CURRENCY_SYMBOL',trim($value));
                }

                SettingsUtility::save_settings($type,trim($value));

            }
        }

        return redirect()->back()->with('success', trans('updated_successfully'));
    }

    public function payments()
    {
        return view('admin.settings.index');
    }

    public function payments_post(Request $request)
    {

        if(get_setting('app_demo') == 'true'){
            return redirect()->back()->with('error', trans('feature_disabled_for_demo_mode'));
        }

        $inputs = $request->except(['_token']);

        if(!empty($inputs)){
            foreach ($inputs as $type => $value) {

                SettingsUtility::save_settings($type,trim($value));

            }
        }

        return redirect()->back()->with('success', trans('updated_successfully'));
    }

    public function gateways()
    {
        return view('admin.settings.index');
    }

    public function gateways_post(Request $request)
    {
        if(get_setting('app_demo') == 'true'){
            return redirect()->back()->with('error', trans('feature_disabled_for_demo_mode'));
        }

        $inputs = $request->except(['_token']);

        if(!empty($inputs)){
            foreach ($inputs as $type => $value) {

                SettingsUtility::save_settings($type,trim($value));

            }
        }

        return redirect()->back()->with('success', trans('updated_successfully'));
    }

    public function ads()
    {
        return view('admin.settings.index');
    }

    public function ads_post(Request $request)
    {
        if(get_setting('app_demo') == 'true'){
            return redirect()->back()->with('error', trans('feature_disabled_for_demo_mode'));
        }

        $inputs = $request->except(['_token']);

        if(!empty($inputs)){
            foreach ($inputs as $type => $value) {

                SettingsUtility::save_settings($type,trim($value));

            }
        }

        return redirect()->back()->with('success', trans('updated_successfully'));
    }

    public function analytics()
    {
        return view('admin.settings.index');
    }

    public function analytics_post(Request $request)
    {
        if(get_setting('app_demo') == 'true'){
            return redirect()->back()->with('error', trans('feature_disabled_for_demo_mode'));
        }

        $inputs = $request->except(['_token']);

        if(!empty($inputs)){
            foreach ($inputs as $type => $value) {

                SettingsUtility::save_settings($type,trim($value));

            }
        }

        return redirect()->back()->with('success', trans('updated_successfully'));
    }

    public function adsense()
    {
        return view('admin.settings.index');
    }

    public function adsense_post(Request $request)
    {
        if(get_setting('app_demo') == 'true'){
            return redirect()->back()->with('error', trans('feature_disabled_for_demo_mode'));
        }

        $inputs = $request->except(['_token']);

        if(!empty($inputs)){
            foreach ($inputs as $type => $value) {

                SettingsUtility::save_settings($type,trim($value));

            }
        }

        return redirect()->back()->with('success', trans('updated_successfully'));
    }

    public function social()
    {
        return view('admin.settings.index');
    }

    public function social_post(Request $request)
    {

        if(get_setting('app_demo') == 'true'){
            return redirect()->back()->with('error', trans('feature_disabled_for_demo_mode'));
        }

        $inputs = $request->except(['_token']);

        if(!empty($inputs)){
            foreach ($inputs as $type => $value) {

                SettingsUtility::save_settings($type,trim($value));

            }
        }

        return redirect()->back()->with('success', trans('updated_successfully'));
    }

}
