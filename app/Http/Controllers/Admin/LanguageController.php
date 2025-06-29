<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Utility\SettingsUtility;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = get_all_languages();
        return view('admin.languages.index', ['languages' => $languages]);
    }

	public function postAdd(Request $request)
    {
        if(get_setting('app_demo') == 'true'){

            return response()->json([
                'status' => 401,
                'messages' => trans('feature_disabled_for_demo_mode')
            ]);

        }

        $validator = Validator::make($request->all(), [
            'language' => 'required|string|max:255',
        ],[
            'language.required' => 'Currency Name is Required',
            'language.string' => 'Currency Name should be a String',
            'language.max' => 'Currency Name max characters should be 255',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                 'status' => 400,
                 'messages' => $validator->getMessageBag()
            ]);
        }

        $language_name = $request->language;
        saveDefaultJSONFile($language_name);

        return response()->json([
            'status' => 200,
            'messages' => trans('added_successfully')
        ]);
	}

    public function edit($language)
    {
        return view('admin.languages.index', ['language' => $language]);
    }

	public function update(Request $request)
    {

        if(get_setting('app_demo') == 'true'){

            return response()->json([
                'status' => 401,
                'message' => trans('feature_disabled_for_demo_mode')
            ]);

        }

		$current_editing_language = $request->currentEditingLanguage;
		$updatedValue = $request->updatedValue;
		$key = $request->key;

		saveJSONFile($current_editing_language, $key, $updatedValue);
        return response()->json([
            'status' => 200,
            'message' => trans('phrase_updated_successfully')
        ]);
	}

    public function changeLanguage($locale)
    {
        App::setLocale($locale);
        Session::put('locale', $locale);
        return redirect()->back();
    }

    public function default()
    {
        $languages = get_all_languages();
        return view('admin.languages.index', ['languages' => $languages]);
    }

    public function postDefault(Request $request)
    {
        if(get_setting('app_demo') == 'true'){
            return redirect()->back()->with('error', trans('feature_disabled_for_demo_mode'));
        }
        $locale = $request->lang;
        $type = 'APP_LOCALE';
        overWriteEnvFile($type, $locale);
        App::setLocale($locale);
        Session::put('locale', $locale);
        return redirect()->back()->with('success', trans('default_language_set_successfully'));
    }

	public function delete(Request $request){

        if(get_setting('app_demo') == 'true'){
            return response()->json(['status' => trans('feature_disabled_for_demo_mode')]);
        }

        $lang = $request->id;

        if (file_exists(resource_path('lang/'.$lang.'.json'))) {

            unlink(resource_path('lang/'.$lang.'.json'));

            return response()->json(['status' => trans('deleted_successfully')]);
        }
	}

    public function dates()
    {
        $languages = get_all_languages();
        $countries = public_path('assets/lang/langlist.json');
        $countries = json_decode(file_get_contents($countries), true);
        return view('admin.languages.index', ['languages' => $languages, 'countries' => $countries]);
    }

    public function postDates(Request $request)
    {
        if(get_setting('app_demo') == 'true'){
            return redirect()->back()->with('error', trans('feature_disabled_for_demo_mode'));
        }

        $inputs = $request->except(['_token']);

        if(!empty($inputs)){
            foreach ($inputs as $type => $value) {

                if($type == 'dates_language'){
                    overWriteEnvFile('DATE_LANGUAGE',trim($value));
                }

                SettingsUtility::save_settings($type,trim($value));

            }
        }

        return redirect()->back()->with('success', trans('updated_successfully'));
    }
}
