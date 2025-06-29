<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin\Categories;
use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));

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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],[
            'name.required' => 'Category Name is Required',
            'name.string' => 'Category Name should be a String',
            'name.max' => 'Category Name max characters should be 255',
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
        $file->move('public/uploads/categories/',$filename);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name, '-');
        $category->image = $filename;
        $category->status = $request->status;
        if ($category->save()) {

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
		$emp = Category::find($id);
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
            'name' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],[
            'name.required' => 'Category Name is Required',
            'name.string' => 'Category Name should be a String',
            'name.max' => 'Category Name max characters should be 255',
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
            $path = 'public/uploads/categories/'.$request->old_image;
            if(File::exists($path)){
                File::delete($path);
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = md5(microtime()).'.'.$ext;
            $file->move('public/uploads/categories/',$filename);
        }else{
            $filename = $request->old_image;
        }

        $category = Category::find($request->category_id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name, '-');
        $category->image = $filename;
        $category->status = $request->status;
        if ($category->update()) {

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

            return response()->json([
                'status' => trans('feature_disabled_for_demo_mode')
            ]);

        }

        $id = $request->id;
        $category = Category::find($id);
        $category->status = '2';
        $category->update();
        return response()->json(['status' => trans('deleted_successfully')]);
	}
}
