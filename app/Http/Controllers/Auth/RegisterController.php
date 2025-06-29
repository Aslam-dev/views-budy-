<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {

        if (get_setting('recaptcha_active') == 'Yes') {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:4|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation' => 'min:4',
                'terms' => 'accepted',
                'g-recaptcha-response' => 'required|recaptcha'
            ],[
                'name.required' => 'Name is Required',
                'name.string' => 'Name should be a String',
                'name.max' => 'Name max characters should be 255',
                'email.required' => 'Email is Required',
                'email.string' => 'Email should be a String',
                'email.email' => 'Email should be an Email',
                'email.max:255' => 'Email max characters should be 255',
                'email.unique:users' => 'Email should be unique from other Users',
                'password.required' => 'Password is Required',
                'password.string' => 'Password should be a String',
                'password.min:4' => 'Password should be min 4 characters',
                'password.same:password_confirmation' => 'Confirmation Password should be the same ',
                'password_confirmation.required' => 'Confirmation Password is Required',
                'password_confirmation.min:4' => 'Password Confirmation should be min 4 characters',
                'terms.accepted' => 'Please check our Terms and Conditions to Register',
                'g-recaptcha-response.recaptcha' => 'Captcha verification failed',
                'g-recaptcha-response.required' => 'Please complete the captcha'
            ]);

        }else{

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:4|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation' => 'min:4',
                'terms' => 'accepted'
            ],[
                'name.required' => 'Name is Required',
                'name.string' => 'Name should be a String',
                'name.max' => 'Name max characters should be 255',
                'email.required' => 'Email is Required',
                'email.string' => 'Email should be a String',
                'email.email' => 'Email should be an Email',
                'email.max:255' => 'Email max characters should be 255',
                'email.unique:users' => 'Email should be unique from other Users',
                'password.required' => 'Password is Required',
                'password.string' => 'Password should be a String',
                'password.min:4' => 'Password should be min 4 characters',
                'password.same:password_confirmation' => 'Confirmation Password should be the same ',
                'password_confirmation.required' => 'Confirmation Password is Required',
                'password_confirmation.min:4' => 'Password Confirmation should be min 4 characters',
                'terms.accepted' => 'Please check our Terms and Conditions to Register',
            ]);

        }


        if ($validator->fails())
        {
            return response()->json([
                 'status' => 400,
                 'messages' => $validator->getMessageBag()
            ]);
        }

        $item = new User();
        $item->name = $request->name;
        $item->slug = Str::slug($request->name);
        $item->email = $request->email;
        $item->image = "avatar.jpg";
        $item->password = Hash::make($request->password);
        $item->wallet = '0.00';
        $item->earnings = '0.00';
        if ($item->save()) {

            Auth::login($item);

            return response()->json([
                'status' => 200,
                'messages' => add('registered_successfully')
            ]);

        }
        else{

            return response()->json([
                'status' => 401,
                'messages' => add('error_something_went_wrong')
            ]);

        }

    }

}
