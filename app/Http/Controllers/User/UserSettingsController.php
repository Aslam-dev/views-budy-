<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Posts;
use App\Models\Payment;
use App\Models\Replies;
use App\Models\Comments;
use App\Models\Favorites;
use App\Models\UserViews;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Notifications;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Admin\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserSettingsController extends Controller
{

    public function profile()
    {
        return view('user.settings.index');
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
        ],[
            'name.required' => 'Category Name is Required',
            'name.string' => 'Category Name should be a String',
            'name.max' => 'Category Name max characters should be 255',
            'email.required' => 'Email is Required',
            'email.string' => 'Email should be a String',
            'email.email' => 'Email should be an Email',
            'email.max:255' => 'Email max characters should be 255',
            'email.unique:users' => 'Email should be unique from other Users',
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

    public function password()
    {
        return view('user.settings.index');
    }

    public function password_update(Request $request)
    {
        if(get_setting('app_demo') == 'true'){
            return response()->json([
                'status' => 401,
                'messages' => trans('feature_disabled_for_demo_mode')
            ]);
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string|min:4',
            'new_password' => 'required|string|min:4|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:4',
        ],[
            'current_password.required' => 'Current Password is Required',
            'new_password.required' => 'Password is Required',
            'new_password.string' => 'Password should be a String',
            'new_password.min:4' => 'Password should be min 4 characters',
            'password.same:confirm_password' => 'Confirmation Password should be the same ',
            'confirm_password.required' => 'Confirmation Password is Required',
            'confirm_password.min:4' => 'Password Confirmation should be min 4 characters',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                 'status' => 400,
                 'messages' => $validator->getMessageBag()
            ]);
        }



        // The passwords matches
        if (!Hash::check($request->get('current_password'), Auth::user()->password))
        {
            return response()->json([
                'status' => 401,
                'messages' => 'Current Password is Invalid'
            ]);
        }

        // Current password and new password same
        if (strcmp($request->get('current_password'), $request->new_password) == 0)
        {
            return response()->json([
                'status' => 401,
                'messages' => 'New Password cannot be same as your current password.'
            ]);
        }

        $item = User::find(Auth::user()->id);
        $item->password =  Hash::make($request->new_password);
        if ($item->update()) {

            return response()->json([
                'status' => 200,
                'messages' => 'User Password updated Successfully'
            ]);
        }
        else{

            return response()->json([
                'status' => 401,
                'messages' => 'Something went wrong'
            ]);

        }

    }


}
