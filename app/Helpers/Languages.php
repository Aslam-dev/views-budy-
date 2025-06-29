<?php

use Illuminate\Support\Facades\File;

// This function helps us to create a new json file for new language
if ( ! function_exists('saveDefaultJSONFile'))
{
	function saveDefaultJSONFile($language_code){
		$language_code = strtolower($language_code);
		if(file_exists(base_path('resources/lang/' . $language_code . '.json'))){
			$newLangFile 	= base_path('resources/lang/' . $language_code . '.json');
			$enLangFile   = base_path('resources/lang/english.json');
			copy($enLangFile, $newLangFile);
		}else {
			$fp = fopen(base_path('resources/lang/' . $language_code . '.json'), 'w');
			$newLangFile = base_path('resources/lang/' . $language_code . '.json');
			$enLangFile   = base_path('resources/lang/english.json');
			copy($enLangFile, $newLangFile);
			fclose($fp);
		}
	}
}

// This function helps us to decode the language json and return that array to us
if ( ! function_exists('openJSONFile'))
{
	function openJSONFile($code)
	{
		$jsonString = [];
		if (file_exists(resource_path('lang/'.$code.'.json'))) {
			$jsonString = file_get_contents(resource_path('lang/'.$code.'.json'));
			$jsonString = json_decode($jsonString, true);
		}
		return $jsonString;
	}
}

// This function helps us to update a phrase inside the language file.
if ( ! function_exists('saveJSONFile'))
{
	function saveJSONFile($language_code, $updating_key, $updating_value){
		$jsonString = [];
		if(file_exists(resource_path('lang/'.$language_code.'.json'))){
			$jsonString = file_get_contents(resource_path('lang/'.$language_code.'.json'));
			$jsonString = json_decode($jsonString, true);
			$jsonString[$updating_key] = $updating_value;
		}else {
			$jsonString[$updating_key] = $updating_value;
		}
		$jsonData = json_encode($jsonString, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
		file_put_contents(resource_path('lang/'.$language_code.'.json'), stripslashes($jsonData));
	}
}

if (!function_exists('get_all_languages'))
{
	function get_all_languages() {
		$language_files = array();
		$all_files = File::allFiles(resource_path('lang'));
		foreach ($all_files as $file) {
			$info = pathinfo($file);
			if( isset($info['extension']) && strtolower($info['extension']) == 'json') {
				$file_name = explode('.json', $info['basename']);
				array_push($language_files, $file_name[0]);
			}
		}

		return $language_files;
	}
}


// This function helps us to get the translated phrase from the file. If it does not exist this function will save the phrase and by default it will have the same form as given
if (!function_exists('add'))
{

	function add($phrase = '') {

		$language_code = 'english';
		$key = strtolower(preg_replace('/\s+/', '_', $phrase));
        $languages = get_all_languages();
        foreach($languages as $language){

            $langArray = openJSONFile($language);
            if (array_key_exists($key, $langArray)) {
            } else {
                $langArray[$key] = ucfirst(str_replace('_', ' ', $key));
                $jsonData = json_encode($langArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                file_put_contents(resource_path('lang/'.$language.'.json'), stripslashes($jsonData));
            }

        }

        $langArray_default = openJSONFile($language_code);

		return ucwords($langArray_default[$key]);
	}
}

?>
