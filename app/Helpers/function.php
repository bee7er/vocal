<?php

use Illuminate\Support\Arr;

if (!function_exists('segments')) {
    /**
     * Converts individual elements of a url into an array.
     */
    function segments($url)
    {
        $segments = explode('/', $url);

        return array_values(array_filter($segments, function ($v) {
            return $v != '';
        }));
    }
}

if (!function_exists('segment')) {
    /**
     * Retrieves the specified indexed element from a url.
     */
    function segment($url, $index, $default)
    {
        return Arr::get(segments($url), $index - 1, $default);
    }
}

if (!function_exists('urlAction')) {
    /**
     * Returns the action portion of the referer url.
     */
    function urlAction()
    {
        //print request()->headers->get('referer');

        return segment(request()->headers->get('referer'), count(segments(request()->headers->get('referer'))), 'error');
    }
}
