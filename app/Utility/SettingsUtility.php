<?php

namespace App\Utility;

use App\Models\Admin\Settings;

class SettingsUtility
{
    public static function get_settings_value($type)
    {
        $value = "";
        $settings = Settings::where('type', $type)->first();

        if (is_null($settings)) {

            $settings = new Settings;
            $settings->type = $type;
            $settings->value = $value;
            $settings->save();
        } else {
            $value = $settings->value;
        }

        return $value;
    }

    public static function save_settings($type, $value)
    {
        $settings = Settings::where('type', $type)->first();
        if (is_null($settings)) {
            $settings = new Settings;
            $settings->type = $type;
            $settings->value = $value;
            $settings->save();
        } else {
            $settings->value = $value;
            $settings->save();
        }
    }
}
