# assghard php-geocoders - The geocoders library for PHP project

Simple PHP library which provides geocoding and reverse geocoding features using different providers such as Nominatim (OpenStreetMap), Google, etc. Get address by coordinates and get coordinates by address

 ## Requirements
- PHP >= 8.0
- PHP cURL

## Installation
Install latest release (for PHP 8+): 

`composer require assghard/php-geocoders`

### For older versions of PHP

If you use PHP 7+: `composer require assghard/php-geocoders:dev-php7`

If you use PHP 5.6: `composer require assghard/php-geocoders:dev-php56`

## Usage

### Nominatim geocoder
Add `GeocodingService` and `NominatimGeocoderProvider` in uses section

```php
use Assghard\PhpGeocoders\GeocodingService;
use Assghard\PhpGeocoders\Providers\NominatimGeocoderProvider;
```

```php
$geocoder = new NominatimGeocoderProvider();
$geocodingService = new GeocodingService($geocoder);

// Get coordinates by address
$geocodeData = $geocodingService->geocode($addressAsString);

// Get address by coordinates
$reverseData = $geocodingService->reverse($latitude, $longitude);

```

You can also provide country code/codes to Geocoder provider: 
```php
$geocoder = new NominatimGeocoderProvider('en');
```

Multiple country codes: 
```php
$geocoder = new NominatimGeocoderProvider(['en', 'pl']);
```


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.