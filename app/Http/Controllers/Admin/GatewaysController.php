<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Utility\SettingsUtility;
use App\Http\Controllers\Controller;

class GatewaysController extends Controller
{
    public function paypal()
    {
        return view('admin.gateways.index');
    }

    public function paypal_post(Request $request)
    {

        if(get_setting('app_demo') == 'true'){
            return redirect()->back()->with('error', trans('feature_disabled_for_demo_mode'));
        }

        $inputs = $request->except(['_token']);

        if(!empty($inputs)){
            foreach ($inputs as $type => $value) {

                if($type == 'paypal_mode'){
                    overWriteEnvFile('PAYPAL_MODE',trim($value));
                }
                if($type == 'paypal_client_id'){
                    overWriteEnvFile('PAYPAL_CLIENT_ID',trim($value));
                }
                if($type == 'paypal_secret'){
                    overWriteEnvFile('PAYPAL_CLIENT_SECRET',trim($value));
                }

                SettingsUtility::save_settings($type,trim($value));

            }
        }

        return redirect()->back()->with('success', trans('updated_successfully'));
    }

    public function stripe()
    {
        return view('admin.gateways.index');
    }

    public function stripe_post(Request $request)
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

    public function razorpay()
    {
        return view('admin.gateways.index');
    }

    public function razorpay_post(Request $request)
    {

        if(get_setting('app_demo') == 'true'){
            return redirect()->back()->with('error', trans('feature_disabled_for_demo_mode'));
        }

        $inputs = $request->except(['_token']);

        if(!empty($inputs)){
            foreach ($inputs as $type => $value) {

                if($type == 'razorpay_key'){
                    overWriteEnvFile('RAZORPAY_KEY',trim($value));
                }
                if($type == 'razorpay_secret'){
                    overWriteEnvFile('RAZORPAY_SECRET',trim($value));
                }

                SettingsUtility::save_settings($type,trim($value));

            }
        }

        return redirect()->back()->with('success', trans('updated_successfully'));
    }

    public function paystack()
    {
        return view('admin.gateways.index');
    }

    public function paystack_post(Request $request)
    {

        if(get_setting('app_demo') == 'true'){
            return redirect()->back()->with('error', trans('feature_disabled_for_demo_mode'));
        }

        $inputs = $request->except(['_token']);

        if(!empty($inputs)){
            foreach ($inputs as $type => $value) {

                if($type == 'paystack_key'){
                    overWriteEnvFile('PAYSTACK_PUBLIC_KEY',trim($value));
                }
                if($type == 'paystack_secret'){
                    overWriteEnvFile('PAYSTACK_SECRET_KEY',trim($value));
                }

                SettingsUtility::save_settings($type,trim($value));

            }
        }

        return redirect()->back()->with('success', trans('updated_successfully'));
    }

    public function mollie()
    {
        return view('admin.gateways.index');
    }

    public function mollie_post(Request $request)
    {

        if(get_setting('app_demo') == 'true'){
            return redirect()->back()->with('error', trans('feature_disabled_for_demo_mode'));
        }

        $inputs = $request->except(['_token']);

        if(!empty($inputs)){
            foreach ($inputs as $type => $value) {

                if($type == 'mollie_key'){
                    overWriteEnvFile('MOLLIE_KEY',trim($value));
                }

                SettingsUtility::save_settings($type,trim($value));

            }
        }

        return redirect()->back()->with('success', trans('updated_successfully'));
    }

    public function flutterwave()
    {
        return view('admin.gateways.index');
    }

    public function flutterwave_post(Request $request)
    {

        if(get_setting('app_demo') == 'true'){
            return redirect()->back()->with('error', trans('feature_disabled_for_demo_mode'));
        }

        $inputs = $request->except(['_token']);

        if(!empty($inputs)){
            foreach ($inputs as $type => $value) {

                if($type == 'flutterwave_key'){
                    overWriteEnvFile('FLW_PUBLIC_KEY',trim($value));
                }

                if($type == 'flutterwave_secret'){
                    overWriteEnvFile('FLW_SECRET_KEY',trim($value));
                }

                if($type == 'flutterwave_hash'){
                    overWriteEnvFile('FLW_SECRET_HASH',trim($value));
                }

                SettingsUtility::save_settings($type,trim($value));

            }
        }

        return redirect()->back()->with('success', trans('updated_successfully'));
    }

    public function bank()
    {
        return view('admin.gateways.index');
    }

    public function bank_post(Request $request)
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
