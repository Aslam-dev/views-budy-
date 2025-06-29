<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Utility\SettingsUtility;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function google()
    {
        return view('admin.auth.index');
    }

    public function google_post(Request $request)
    {

        if(get_setting('app_demo') == 'true'){
            return redirect()->back()->with('error', trans('feature_disabled_for_demo_mode'));
        }

        $inputs = $request->except(['_token']);

        if(!empty($inputs)){
            foreach ($inputs as $type => $value) {

                if($type == 'google_client_id'){
                    overWriteEnvFile('GOOGLE_CLIENT_ID',trim($value));
                }
                if($type == 'google_secret'){
                    overWriteEnvFile('GOOGLE_CLIENT_SECRET',trim($value));
                }
                if($type == 'google_redirect_uri'){
                    overWriteEnvFile('GOOGLE_REDIRECT_URI',trim($value));
                }

                SettingsUtility::save_settings($type,trim($value));

            }
        }

        return redirect()->back()->with('success', trans('updated_successfully'));
    }

    public function facebook()
    {
        return view('admin.auth.index');
    }

    public function facebook_post(Request $request)
    {

        if(get_setting('app_demo') == 'true'){
            return redirect()->back()->with('error', trans('feature_disabled_for_demo_mode'));
        }

        $inputs = $request->except(['_token']);

        if(!empty($inputs)){
            foreach ($inputs as $type => $value) {

                if($type == 'facebook_client_id'){
                    overWriteEnvFile('FACEBOOK_CLIENT_ID',trim($value));
                }
                if($type == 'facebook_secret'){
                    overWriteEnvFile('FACEBOOK_CLIENT_SECRET',trim($value));
                }
                if($type == 'facebook_redirect_uri'){
                    overWriteEnvFile('FACEBOOK_REDIRECT_URI',trim($value));
                }

                SettingsUtility::save_settings($type,trim($value));

            }
        }

        return redirect()->back()->with('success', trans('updated_successfully'));
    }

    public function email()
    {
        return view('admin.auth.index');
    }

    public function email_post(Request $request)
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

    public function recaptcha()
    {
        return view('admin.auth.index');
    }

    public function recaptcha_post(Request $request)
    {

        if(get_setting('app_demo') == 'true'){
            return redirect()->back()->with('error', trans('feature_disabled_for_demo_mode'));
        }

        $inputs = $request->except(['_token']);

        if(!empty($inputs)){
            foreach ($inputs as $type => $value) {

                if($type == 'recaptcha_site'){
                    overWriteEnvFile('RECAPTCHA_SITE_KEY',trim($value));
                }
                if($type == 'recaptcha_secret'){
                    overWriteEnvFile('RECAPTCHA_SECRET_KEY',trim($value));
                }

                SettingsUtility::save_settings($type,trim($value));

            }
        }

        return redirect()->back()->with('success', trans('updated_successfully'));
    }
}
