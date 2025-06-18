<?php

if (!function_exists('getFilterUrl')) {
    function getFilterUrl($newParams)
    {
        return route('admin.product', array_merge(request()->except(array_keys($newParams)), $newParams));
    }
}
