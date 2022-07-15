<?php

declare(strict_types=1);

namespace Assghard\PhpGeocoders\Interfaces;

interface GeocodingInterface {

    /**
     * Get coordinates by address
     *
     * @param string $address
     */
    public function geocoding(string $address);

    /**
     * Get address by coordinates
     *
     * @param $latitude
     * @param $longitude
     */
    public function reverseGeocoding(float $latitude, float $longitude);

}
