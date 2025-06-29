<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use App\Mail\ForgotPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\GeneralMail;
use App\Models\Admin\EmailTemplate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{

    public function forgot()
    {
        if (Auth::user()){
            return redirect()->back();
        }
        return view('auth.forgot');
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ],[
            'email.required' => 'Email is Required',
            'email.email' => 'Email should be an Email',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                 'status' => 400,
                 'messages' => $validator->getMessageBag()
            ]);

        }else {

            $token = Str::random(64);
            $user = DB::table('users')->where('email', $request->email)->first();

            $details = [
                'body' => route('reset', ['email'=> $request->email, 'token' => $token])
            ];

            if ($user){

                DB::table('password_reset_tokens')->insert([
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);


                if (get_setting('enable_emails') == 'Yes') {

                        //Replace paremeter
                        $replace = array(
                            '{url}'              => env('APP_URL'),
                            '{logo}'              => get_setting('logo_dark'),
                            '{sitename}'              => get_setting('site_name'),
                            '{year}'              => date('Y'),
                            '{link}'              => route('reset', ['email'=> $request->email, 'token' => $token])
                        );

                        //Send email
                        $template = EmailTemplate::where('name','forgot')->first();
                        $template->body = process_string($replace, $template->body);

                        Mail::to($request->email)->send(new GeneralMail($template));
                }

                return response()->json([
                    'status' => 200,
                    'messages' => 'Reset password link has been sent to your e-mail!',
                ]);

            }else{

                return response()->json([
                   'status' => 401,
                   'messages' => 'This email is not register with us!',
                ]);

            }
        }
    }

    public function resetPassword(Request $request)
    {
        return view('auth.reset', [
            'email' => $request->email,
            'token' => $request->token,
        ]);
    }



    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'new_password' => 'required|min:6|max:50',
            'c_new_password' => 'required|same:new_password',
        ],[
           'c_new_password.same' => 'Password does not match',
           'c_new_password.required' => 'New confirm password is required'
        ]);

        if ($validator->fails()){

            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag(),
            ]);

        }else{


            $updatePassword = DB::table('password_reset_tokens')
                                ->where([
                                    'email' => $request->email,
                                    'token' => $request->token
                                ])
                                ->first();

            if ($updatePassword){


                User::where('email', $request->email)->update(['password' => Hash::make($request->new_password)]);

                DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();

                return response()->json([
                    'status' => 200,
                    'messages' => "Password changed successfully! <br> <a href='/'>Login Now</a>",
                ]);

            }else{

                return response()->json([
                    'status' => 401,
                    'messages' => 'Invalid Reset Password Token!',
                ]);

            }
        }
    }

}
