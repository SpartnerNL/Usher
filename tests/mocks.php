<?php

if (!function_exists('event')) {
    function event()
    {
    }
}

if (!function_exists('app')) {
    function app()
    {
    }
}

if (!function_exists('config')) {
    function config($key)
    {
        if ($key == 'usher.permissions.strict') {
            return true;
        }
    }
}
