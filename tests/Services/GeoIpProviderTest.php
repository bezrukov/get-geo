<?php

namespace Bezrukov\GetGeo\Tests\Services;

use Bezrukov\GetGeo\Services\GeoIpProvider;
use Bezrukov\GetGeo\Services\GeoIpRequest;
use Bezrukov\GetGeo\Services\GeoIpResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class GeoIpProviderTest extends TestCase
{
    public function testGetData()
    {
        $mock = new MockHandler([
            new Response(200, [],'{"city": "TestData"}'),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        $request = $this->getMockRequest();
        $provider = new GeoIpProvider($client, $this->getMockResponse());

        $responseInst = $provider->getData($request);
        $this->assertEquals('TestData', $responseInst->city);
    }

    private function getMockResponse()
    {
        $response = $this->createMock(GeoIpResponse::class);
        $response->method('setFromArray')->willReturn('');

        return $response;
    }

    /**
     * @param string $ip
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    private function getMockRequest($ip = ''): \PHPUnit\Framework\MockObject\MockObject
    {
        $request = $this->createMock(GeoIpRequest::class);
        $request->method('getIp')->willReturn($ip);

        return $request;
    }
}