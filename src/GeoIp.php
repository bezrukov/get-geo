<?php

namespace Bezrukov\GetGeo;

use Bezrukov\GetGeo\Services\GeoIpRequest;
use Bezrukov\GetGeo\Services\GeoIpProvider;
use Bezrukov\GetGeo\Services\GeoIpResponse;
use GuzzleHttp\Client;

class GeoIp
{
    const IP_API = 'http://ip-api.com/json/';

    public function getCityFromIp($ip = null)
    {
        $request = GeoIpRequest::getFromData($ip);

        $response = new GeoIpResponse();
        $guzzleClient =  new Client(['base_uri' => self::IP_API]);

        $provider = new GeoIpProvider($guzzleClient, $response);

        try {
            return $provider->getData($request)->city;
        } catch (GeoIpException $e) {
            return $e->getMessage();
        }
    }
}