<?php

namespace Rum\Sandbox;

class CurlHandle
{
    public $curl;

    public function __construct()
    {
        $url = getenv('MOYSKLAD_API_URL')."entity/product";
        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD,
            "semenovra@admin@:admin123");
//        return $this->curl;
    }

}