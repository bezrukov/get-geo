<?php

namespace Bezrukov\GetGeo\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GeoIpProvider
{
    /** @var Client */
    private $httpClient;

    public function __construct($httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $ip
     * @return GeoIpResponse
     * @throws GuzzleException
     */
    public function getData(string $ip = ''): GeoIpResponse
    {
        $response = new GeoIpResponse();

        $apiResponse = $this->httpClient->request(
            'GET',
            $ip
        );

        $contents = $apiResponse->getBody()->getContents();

        $result = json_decode($contents, true) ?: [];

        $response->setFromArray($result);

        return $response;
    }
}