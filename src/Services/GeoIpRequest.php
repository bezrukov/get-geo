<?php

namespace Bezrukov\GetGeo\Services;

class GeoIpRequest
{
    /** @var string */
    private $ip;

    public function __construct($ip)
    {
        $this->ip = $ip;
    }

    public static function getFromData($ip): GeoIpRequest
    {
        return new self($ip ?? '');
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }


}