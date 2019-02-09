<?php

namespace Bezrukov\GetGeo;

use Bezrukov\GetGeo\Services\GeoIpRequest;
use Bezrukov\GetGeo\Services\GeoIpProvider;

class GeoIp
{
    const IP_API = 'http://ip-api.com/json/';

    public function getCityFromIp($ip = null)
    {
        $request = GeoIpRequest::getFromData($ip);

        $provider = new GeoIpProvider(self::IP_API);

        try {
            return $provider->getData($request)->city;
        } catch (GeoIpException $e) {
            return $e->getMessage();
        }
    }
}