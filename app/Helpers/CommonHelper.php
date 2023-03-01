<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('_pre')) {
    function _pre($response)
    {
        echo "<pre>";
        print_r($response);
        echo "</pre>";
        return $response;
    }
}
