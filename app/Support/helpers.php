<?php

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

if (!function_exists('settings')) {
    /**
     * Get / set the specified settings value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  array|string  $key
     * @param  mixed  $default
     * @return mixed
     */
    function settings($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('anlutro\LaravelSettings\SettingStore');
        }

        return app('anlutro\LaravelSettings\SettingStore')->get($key, $default);
    }
}

function getNamePermission()
{
return Permission::select('name')->get();
}

function getPermission()
{
return Permission::select('id', 'name')->get();
}

function getRole()
{
return Role::select('id', 'name')->get();
}