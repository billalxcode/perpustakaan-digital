<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class DeviceSettings extends Settings
{
    public static function group(): string
    {
        return 'devices';
    }
}
