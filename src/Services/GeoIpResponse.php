<?php

namespace Bezrukov\GetGeo\Services;

class GeoIpResponse implements \JsonSerializable
{
    /** @var string  */
    public $city = '';

    public function setFromArray(array $data)
    {
        if(isset($data['city'])) {
            $this->city = $data['city'];
        }
    }

    public function jsonSerialize()
    {
        return [
            'city' => $this->city
        ];
    }
}