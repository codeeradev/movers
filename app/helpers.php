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
    try {
        $settings = Setting::first();
    } catch (\Throwable $e) {
        return $default;
    }

    if (!$settings) {
        return $default;
    }

    return $settings->{$key} ?? $default;
}

}

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return site_setting($key, $default);
    }
}
