<?php

namespace Bezrukov\GetGeo\Tests\Services;

use Bezrukov\GetGeo\Services\GeoIpProvider;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class GeoIpProviderTest extends TestCase
{

    /**
     * @dataProvider dataProvider
     *
     * @param int $code
     * @param string $body
     * @param string $expected
     * @param string $ip
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetData(int $code, string $body, string $expected, string $ip = '')
    {
        $client = $this->getHttpClientMock($code, $body);
        $provider = new GeoIpProvider($client);

        $responseInst = $provider->getData($ip);
        $this->assertEquals($expected, $responseInst->city);
    }

    public function dataProvider(): array
    {
        return [
            [200, '{"city": "TestData"}', 'TestData'],
            [200, '{"city": ""}', ''],
            [200, '{}', ''],
            [200, '{"ip": "123.23.23.11"}', ''],
            [200, '{"ip": "123.23.23.11", "city": "TestData"}', 'TestData', '123.23.23.11'],
        ];
    }

    /**
     * @param int $code
     * @param string $responseBody
     * @return Client
     */
    private function getHttpClientMock(int $code = 200, string $responseBody = '{}'): Client
    {
        $mock = new MockHandler(
            [
                new Response($code, [], $responseBody),
            ]
        );

        $handler = HandlerStack::create($mock);

        return new Client(['handler' => $handler]);
    }
}