<?php

declare(strict_types=1);

namespace Assghard\PhpGeocoders\Providers;

use Assghard\PhpGeocoders\Interfaces\GeocodingInterface;
use Assghard\PhpGeocoders\Providers\HttpProvider;

class NominatimGeocoderProvider implements GeocodingInterface {

    /**
     * @var HttpProvider
     */
    private $httpProvider;

	public function __construct(
        private string|array $countryCodes = [],
        private array $params = ['format' => 'jsonv2', 'addressdetails' => true],
        private string $geocoderUrl = 'https://nominatim.openstreetmap.org'
    ) {
        $this->httpProvider = new HttpProvider($this->geocoderUrl);
    }

    /**
     * Get address by coordinates
     *
     * @param $latitude
     * @param $longitude
     * @return array|bool Array of results or false
     */
    public function reverseGeocoding(float $latitude, float $longitude): array|bool
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
    public function geocoding(string $address): array|bool
    {
        return $this->httpProvider->getRequest('search.php', $this->prepareRequestParams(['q' => $address]));
    }

    private function prepareRequestParams(array $params): array
    {
        if (!empty($this->countryCodes)) {
            if (is_array($this->countryCodes)) {
                $this->params['countrycodes'] = implode(',', $this->countryCodes);
            } else {
                $this->params['countrycodes'] = $this->countryCodes;
            }
        }

        return array_merge($this->params, $params);
    }
    
}
