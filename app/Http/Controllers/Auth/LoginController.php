<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function create()
    {

        Session::put('previous_url', URL::previous());

        return view('auth.login');
    }

    public function store(Request $request)
    {

        if (get_setting('recaptcha_active') == 'Yes') {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string|min:4',
                'g-recaptcha-response' => 'required|recaptcha'
            ],[
                'email.required' => 'Email is Required',
                'email.email' => 'Email should be an Email',
                'password.required' => 'Password is Required',
                'password.string' => 'Password should be a String',
                'password.min:4' => 'Password should be min 4 characters',
                'g-recaptcha-response.recaptcha' => 'Captcha verification failed',
                'g-recaptcha-response.required' => 'Please complete the captcha'
            ]);

        } else {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string|min:4',
            ],[
                'email.required' => 'Email is Required',
                'email.email' => 'Email should be an Email',
                'password.required' => 'Password is Required',
                'password.string' => 'Password should be a String',
                'password.min:4' => 'Password should be min 4 characters',
            ]);

        }


        if ($validator->fails())
        {
            return response()->json([
                 'status' => 400,
                 'messages' => $validator->getMessageBag()
            ]);
        }else {

            $remember_me = $request->has('remember_me') ? true : false;

            $user = User::where('email', $request->email)->first();

            if ($user){

                if ($user->deleted == '1') {

                    return response()->json([
                        'status' => 402,
                        'messages' => trans('account_deleted')
                    ]);

                } else {

                    if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember_me)) {

                        return response()->json([
                           'status' => 200,
                           'intended' => Session::get('previous_url'),
                           'messages' => trans('login_successfully')
                        ]);

                    }else{

                        return response()->json([
                           'status' => 401,
                           'messages' => trans('email_or_password_does_not_match'),
                        ]);
                    }
                }


            }else{

                return response()->json([
                    'status' => 402,
                    'messages' => trans('user_not_found'),
                ]);
            }
        }


    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
