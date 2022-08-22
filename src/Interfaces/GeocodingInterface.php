<?php

namespace Assghard\PhpGeocoders\Interfaces;

interface GeocodingInterface {

    /**
     * Get coordinates by address
     *
     * @param string $address
     */
    public function geocoding($address);

    /**
     * Get address by coordinates
     *
     * @param $latitude
     * @param $longitude
     */
    public function reverseGeocoding($latitude, $longitude);

}
