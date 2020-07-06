<?php
namespace App\CustomClass;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Request;



class URLManager {

    public static function getBackURL($defaultUrl) {
        $previousUrl = URL::previous();
        $hostName = Request::getHost();
        if(Str::startsWith($previousUrl, $hostName)) {
            return $previousUrl;
        }
        return $defaultUrl;
    }
}
