<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', ['users' => $users]);

    }

    public function store(Request $request)
    {

        if(get_setting('app_demo') == 'true'){
            return response()->json([
                'status' => 401,
                'messages' => trans('feature_disabled_for_demo_mode')
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],[
            'name.required' => 'Category Name is Required',
            'name.string' => 'Category Name should be a String',
            'name.max' => 'Category Name max characters should be 255',
            'email.required' => 'Email is Required',
            'email.string' => 'Email should be a String',
            'email.email' => 'Email should be an Email',
            'email.max:255' => 'Email max characters should be 255',
            'email.unique:users' => 'Email should be unique from other Users',
            'password.required' => 'Password is Required',
            'password.string' => 'Password should be a String',
            'password.min:4' => 'Password should be min 4 characters',
            'image.required' => 'Image is Required',
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

        $file = $request->file('image');
        $ext = $file->getClientOriginalExtension();
        $filename = md5(microtime()).'.'.$ext;
        $file->move('public/uploads/users/',$filename);

        $item = new User();
        $item->name = $request->name;
        $item->slug = Str::slug($request->name);
        $item->email = $request->email;
        $item->password = Hash::make($request->password);
        $item->image = $filename;
        $item->role = $request->role;
        $item->wallet = '0.00';
        $item->earnings = '0.00';
        if ($item->save()) {

            return response()->json([
                'status' => 200,
                'messages' => trans('added_successfully')
            ]);

        }
        else{

            return response()->json([
                'status' => 401,
                'messages' => trans('error_something_went_wrong')
            ]);

        }
    }

    public function edit(Request $request)
    {
		$id = $request->id;
		$emp = User::find($id);
		return response()->json($emp);
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
            'edit_name' => 'required|string|max:255',
            'edit_email' => 'required|string|email|max:255',
            'edit_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],[
            'edit_name.required' => 'Category Name is Required',
            'edit_name.string' => 'Category Name should be a String',
            'edit_name.max' => 'Category Name max characters should be 255',
            'edit_email.required' => 'Email is Required',
            'edit_email.string' => 'Email should be a String',
            'edit_email.email' => 'Email should be an Email',
            'edit_email.max:255' => 'Email max characters should be 255',
            'edit_image.image' => 'Image Field should be an Image',
            'edit_image.mimes' => 'Jpeg, Png, Jpg, Gif, Svg are Allowed',
            'edit_image.max' => 'Image max file is 2048',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                 'status' => 400,
                 'messages' => $validator->getMessageBag()
            ]);
        }

        if($request->hasFile('edit_image'))
        {
            if ($request->old_image != 'avatar.jpg') {
                $path = 'public/uploads/users/'.$request->old_image;
                if(File::exists($path)){
                    File::delete($path);
                }
            }
            $file = $request->file('edit_image');
            $ext = $file->getClientOriginalExtension();
            $filename = md5(microtime()).'.'.$ext;
            $file->move('public/uploads/users/',$filename);
        }else{
            $filename = $request->old_image;
        }

        $item = User::find($request->user_id);
        $item->name = $request->edit_name;
        $item->slug = Str::slug($request->edit_name);
        $item->email = $request->edit_email;
        if ($request->edit_password) {
            $item->password = Hash::make($request->edit_password);
        }
        $item->image = $filename;
        $item->role = $request->edit_role;
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

	public function destroy(Request $request){

        if(get_setting('app_demo') == 'true'){
            return response()->json(['status' => trans('feature_disabled_for_demo_mode')]);
        }

        $id = $request->id;
        $user = User::find($id);
        $user->deleted = '1';
        $user->update();
        return response()->json(['status' => trans('deleted_successfully')]);
	}

    public function view(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);

        return view('admin.users.user', ['user' => $user]);
    }

    public function funds($id)
    {
        $user = User::find($id);
        return view('admin.users.funds', ['user' => $user]);

    }

    public function update_funds(Request $request)
    {
        if(get_setting('app_demo') == 'true'){
            return redirect()->back()->with('error', trans('feature_disabled_for_demo_mode'));
        }

        $amount = $request->amount;
        $id = $request->id;

        DB::table('funds')->insert([
            'user_id' => $id,
            'fund_id' => strRandom(),
            'gateway' => 'Admin Topup',
            'amount' => $amount,
            'percentage_applied' => '0.00',
            'transaction_fee' => '0.00',
            'total' => $amount,
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


        // Add Funds to User
        User::find($id)->increment('wallet', $amount);

        return redirect()->back()->with('success', get_setting('currency_symbol').$amount .' '. trans('deposited_successfully'));
    }
}
