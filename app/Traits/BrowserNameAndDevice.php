<?php

namespace App\Traits;

use BrowserDetect;

trait BrowserNameAndDevice
{
    public function getBrowserName(): string
    {
        return BrowserDetect::browserName();
    }

    public function getDeviceName(): string
    {
        return BrowserDetect::deviceFamily().' '.BrowserDetect::deviceModel();
    }
}
