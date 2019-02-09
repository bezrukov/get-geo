<?php

namespace Bezrukov\GetGeo\Services;

use Bezrukov\GetGeo\GeoIpException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GeoIpProvider
{
    public $httpClient;

    public function __construct($baseUrl)
    {
        $this->httpClient = new Client(['base_uri' => $baseUrl]);
    }

    /**
     * @param GeoIpRequest $request
     * @return GeoIpResponse
     * @throws GeoIpException
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
            var_dump($e->getMessage());
            throw new GeoIpException('System service error request');
        }

        $contents = $apiResponse->getBody()->getContents();

        try {
            $result = \GuzzleHttp\json_decode($contents, true) ?: [];
        } catch (\InvalidArgumentException $e) {
            throw new GeoIpException('System service error');
        }

        $response->setFromArray($result);

        return $response;
    }
}