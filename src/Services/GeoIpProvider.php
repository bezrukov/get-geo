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
     * @param GeoIpRequest $request
     * @return GeoIpResponse
     * @throws GuzzleException
     */
    public function getData(GeoIpRequest $request): GeoIpResponse
    {
        $response = new GeoIpResponse();

        try {
            $apiResponse = $this->httpClient->request(
                'GET',
                $request->getIp()
            );

        } catch (GuzzleException $e) {
            throw $e;
        }

        $contents = $apiResponse->getBody()->getContents();

        try {
            $result = \GuzzleHttp\json_decode($contents, true) ?: [];
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }

        $response->setFromArray($result);

        return $response;
    }
}