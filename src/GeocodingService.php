<?php

declare(strict_types=1);

namespace Assghard\PhpGeocoders;

use Assghard\PhpGeocoders\Interfaces\GeocodingInterface;

class GeocodingService {

    private $geocoder;

	public function __construct(GeocodingInterface $geocoder)
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
    public function reverse(float $latitude, float $longitude)
    {
        return $this->geocoder->reverseGeocoding($latitude, $longitude);
    }

    /**
     * Get coordinates by address
     *
     * @param string $address
     * @return array|boolean
     */
    public function geocode(string $address)
    {
        return $this->geocoder->geocoding($address);
    }
}
