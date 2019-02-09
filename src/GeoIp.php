<?php

namespace Bezrukov\GetGeo;

use Bezrukov\GetGeo\Services\GeoIpRequest;
use Bezrukov\GetGeo\Services\GeoIpProvider;
use GuzzleHttp\Client;

class GeoIp
{
    const IP_API = 'http://ip-api.com/json/';

    /**
     * @param null $ip
     * @return Services\GeoIpResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getInfoFromIp($ip = null): Services\GeoIpResponse
    {
        $request = GeoIpRequest::getFromData($ip);

        $guzzleClient =  new Client(['base_uri' => self::IP_API]);

        $provider = new GeoIpProvider($guzzleClient);

        return $provider->getData($request);
    }
}