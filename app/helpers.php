<?php

use App\Models\Setting;

if (!function_exists('site_setting')) {
    /**
     * Get website setting value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
   function site_setting($key, $default = null)
{
    $settings = Setting::first();

    if (!$settings) {
        return $default;
    }

    return $settings->{$key} ?? $default;
}

}
