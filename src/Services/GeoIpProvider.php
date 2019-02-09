<?php

namespace Bezrukov\GetGeo\Services;

use Bezrukov\GetGeo\GeoIpException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GeoIpProvider
{
    /** @var Client */
    private $httpClient;

    /** @var GeoIpResponse */
    private $response;

    public function __construct($httpClient, $Response)
    {
        $this->httpClient = $httpClient;
        $this->response = $Response;
    }

    /**
     * @param GeoIpRequest $request
     * @return GeoIpResponse
     * @throws GeoIpException
     */
    public function getData(GeoIpRequest $request): GeoIpResponse
    {
        try {
            $apiResponse = $this->httpClient->request(
                'GET',
                $request->getIp()
            );

        } catch (GuzzleException $e) {
            throw new GeoIpException('System service error request');
        }

        $contents = $apiResponse->getBody()->getContents();

        try {
            $result = \GuzzleHttp\json_decode($contents, true) ?: [];
        } catch (\InvalidArgumentException $e) {
            throw new GeoIpException('System service error');
        }

        $this->response->setFromArray($result);

        return $this->response;
    }
}