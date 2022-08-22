<?php

namespace Assghard\PhpGeocoders;

class GeocodingService {

    private $geocoder;

	public function __construct($geocoder)
	{
        $this->geocoder = $geocoder;
	}

    /**
     * Get address by coordinates
     *
     * @param float $latitude
     * @param float $longitude
     * @return array|boolean
     */
    public function reverse($latitude, $longitude)
    {
        return $this->geocoder->reverseGeocoding($latitude, $longitude);
    }

    /**
     * Get coordinates by address
     *
     * @param string $address
     * @return array|boolean
     */
    public function geocode($address)
    {
        return $this->geocoder->geocoding($address);
    }
}
