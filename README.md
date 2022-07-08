# assghard php-geocoders - The geocoders library for PHP project

 ## Requirements
- PHP >= 8.0
- PHP cURL

## Installation
`composer require assghard/php-geocoders`

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