<?php

/**
 * Google Maps javascript API documentation: https://developers.google.com/maps/documentation/javascript/overview
 */

declare(strict_types=1);

namespace Assghard\PhpGeocoders\Providers;

use Assghard\PhpGeocoders\Interfaces\GeocodingInterface;

class GoogleGeocoderProvider implements GeocodingInterface
{

    const GEOCODER_URL = 'https://maps.googleapis.com/maps/api/geocode/json';

    private $params;

    /**
     * @param string $googleMapsKey - Google Maps API key
     * @param string $language - Language code. See Google documentation: https://developers.google.com/admin-sdk/directory/v1/languages
     */
    public function __construct(
        private string $googleMapsKey, // Geocoding feature should be enabled in Google panel
        private string $language = 'en',
    ) {
        $this->params = [$this->googleMapsKey, $this->language];
    }

    /**
     * Get address by coordinates
     *
     * @param $latitude
     * @param $longitude
     */
    public function reverseGeocoding(float $latitude, float $longitude): array|bool
    {
        $params = array_merge($this->params, ['latlng' => $latitude . ',' . $longitude]);

        try {
            $response = file_get_contents(self::GEOCODER_URL . '?' . http_build_query($params));
            if (empty($response)) {
                return false;
            }

            $response = json_decode($response, true);
            if ($response['status'] != 'OK') {
                return false;
            }

            if (empty($response['results'])) {
                return false;
            }

            $components = $response['results'][0]['address_components'];
            $geometry = $response['results'][0]['geometry']['location'];
            $address = $this->parseAddressComponents($components);

            return [
                'address_string' => $response['results'][0]['formatted_address'],
                'city' => $address['locality'],
                'street' => $address['route'],
                'house_number' => $address['street_number'],
                'pna' => $address['postal_code'],
                'lat' => $geometry['lat'],
                'lng' => $geometry['lng']
            ];
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function geocoding(string $address): array|bool
    {
        $params = array_merge($this->params, ['address' => $address]);

        try {
            $response = file_get_contents(self::GEOCODER_URL . '?' . http_build_query($params));
            if (empty($response)) {
                return false;
            }

            $response = json_decode($response, true);
            if ($response['status'] != 'OK') {
                return false;
            }

            if (empty($response['results'])) {
                return false;
            }

            $components = $response['results'][0]['address_components'];
            $geometry = $response['results'][0]['geometry']['location'];
            $address = $this->parseAddressComponents($components);

            return [
                'address_string' => $response['results'][0]['formatted_address'],
                'city' => $address['locality'],
                'street' => $address['route'],
                'house_number' => $address['street_number'],
                'pna' => $address['postal_code'],
                'lat' => $geometry['lat'],
                'lng' => $geometry['lng']
            ];
        } catch (\Throwable $th) {
            return false;
        }
    }

    protected function parseAddressComponents($components)
    {
        $address = [
            'route', // street
            'street_number',
            'locality', // city
            'postal_code'
        ];

        $data = [];
        foreach ($address as $addr) {
            foreach ($components as $component) {
                if (array_search($addr, $component['types']) !== false) {
                    $data[$addr] = $component['long_name'];
                }
            }
        }

        return $data;
    }
}
