<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class AppSettings extends Settings
{
    public static function group(): string
    {
        return 'app';
    }
}
