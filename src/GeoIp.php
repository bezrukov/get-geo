<?php

namespace Bezrukov\GetGeo;

use Bezrukov\GetGeo\Services\GeoIpProvider;
use GuzzleHttp\Client;

class GeoIp
{
    const IP_API = 'http://ip-api.com/json/';

    private $httpClient;

    public function __construct($httpClient = null)
    {
        $this->httpClient = $httpClient ?? Client::class;
    }

    /**
     * @param string $ip
     * @return Services\GeoIpResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getInfoFromIp($ip = ''): Services\GeoIpResponse
    {
        $client = new $this->httpClient(['base_uri' => self::IP_API]);

        $provider = new GeoIpProvider($client);

        return $provider->getData($ip ?? '');
    }
}