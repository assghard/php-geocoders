<?php

declare(strict_types=1);

namespace Assghard\PhpGeocoders\Providers;

use Assghard\PhpGeocoders\Interfaces\GeocodingInterface;
use Assghard\PhpGeocoders\Providers\HttpProvider;

class NominatimGeocoderProvider implements GeocodingInterface {

    /**
     * @var string|array
     */
    private $countryCodes;

    /**
     * @var string
     */
    private $geocoderUrl;

    /**
     * @var HttpProvider
     */
    private $httpProvider;

	public function __construct($countryCodes = [], $geocoderUrl = 'https://nominatim.openstreetmap.org') {
        $this->countryCodes = $countryCodes;
        $this->geocoderUrl = $geocoderUrl;
        $this->httpProvider = new HttpProvider($geocoderUrl);
    }

    /**
     * Get address by coordinates
     *
     * @param $latitude
     * @param $longitude
     * @return array|bool Array of results or false
     */
    public function reverseGeocoding(float $latitude, float $longitude)
    {
        return $this->httpProvider->getRequest('reverse.php', $this->prepareRequestParams([
            'lat' => $latitude,
            'lon' => $longitude,
            'zoom' => 18
        ]));
    }

    /**
     * Get coordinates by address
     *
     * @param string $address Address string
     * @return array|bool Array of results or false
     */
    public function geocoding(string $address)
    {
        return $this->httpProvider->getRequest('search.php', $this->prepareRequestParams(['q' => $address]));
    }

    private function prepareRequestParams(array $params): array
    {
        $defaultParams = ['format' => 'jsonv2', 'addressdetails' => true];
        if (!empty($this->countryCodes)) {
            if (is_array($this->countryCodes)) {
                $defaultParams['countrycodes'] = implode(',', $this->countryCodes);
            } else {
                $defaultParams['countrycodes'] = $this->countryCodes;
            }
        }

        return array_merge($defaultParams, $params);
    }
    
}
