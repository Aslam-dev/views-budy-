<?php

//return file path with public

use App\Utility\SettingsUtility;
use Illuminate\Support\Facades\File;

if (!function_exists('my_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function my_asset($path, $secure = null)
    {
        return app('url')->asset('public/' . $path, $secure);
    }
}


//Get Settings
if (!function_exists('get_setting')) {
    function get_setting($key, $default = "")
    {
        $setting =  SettingsUtility::get_settings_value($key) ;
        return $setting == "" ? $default : $setting;
    }
}

//overWriteENVFile
if (!function_exists('overWriteEnvFile'))
{
    function overWriteEnvFile($type, $val)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            $val = '"'.trim($val).'"';
            if(is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0){
                file_put_contents($path, str_replace(
                    $type.'="'.env($type).'"', $type.'='.$val, file_get_contents($path)
                ));
            }
            else{
                file_put_contents($path, file_get_contents($path)."\r\n".$type.'='.$val);
            }
        }
    }
}

//strRandom
if (!function_exists('strRandom'))
{
    function strRandom($length = 12)
    {
        $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

//ytThumbnail
if (!function_exists('ytThumbnail'))
{
    function ytThumbnail($id) {
        return "https://img.youtube.com/vi/" . $id . "/hqdefault.jpg";
    }
}

//ytDuration
if (!function_exists('ytDuration'))
{
    function ytDuration($video_id) {
        $key = 'AIzaSyBqf8ALU_1lHFhhi_SKHRV3dF_u4nF_S30';
        $url = 'https://www.googleapis.com/youtube/v3/videos?id='.$video_id.'&key='.$key.'&part=contentDetails';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response);
        //dd($response_a);
        $duration =  $response_a->items[0]->contentDetails->duration; //get video duaration
        $duration = new DateInterval($duration);
        return $duration->format('%H:%I:%S');
    }
}


//timeToSeconds
if (!function_exists('timeToSeconds'))
{
    function timeToSeconds(string $time): int
    {
        $arr = explode(':', $time);
        if (count($arr) === 3) {
            return $arr[0] * 3600 + $arr[1] * 60 + $arr[2];
        }
        return $arr[0] * 60 + $arr[1] - 1;
    }
}

/**
 * Use to convert large positive numbers in to short form like 1K+, 100K+, 199K+, 1M+, 10M+, 1B+ etc
 */
if (!function_exists('short'))
{
    function short($n, $precision = 1 ) {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K+';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M+';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B+';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T+';
        }

    // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
    // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ( $precision > 0 ) {
            $dotzero = '.' . str_repeat( '0', $precision );
            $n_format = str_replace( $dotzero, '', $n_format );
        }

        return $n_format . $suffix;
    }
}


if (!function_exists('getSocialAvatar')) {

    function getSocialAvatar($file, $path, $user){
        $fileContents = file_get_contents($file);
        $filename = md5(microtime()).'_'.$user->getId().'.jpg';
        $file = File::put(public_path() . $path . $filename, $fileContents);
        return $filename;
    }
}


if( !function_exists('process_string') ){

	function process_string($search_replace, $string){
	   	$result = $string;
	   	foreach($search_replace as $key=>$value){
			$result = str_replace($key, $value, $result);
	   	}
	   	return $result;
	}

}
