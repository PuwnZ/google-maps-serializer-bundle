# Readme

## Overview

The Google Maps Serializer Bundle project provides a serialization of a response from Google Map Bundles for you Symfony 4+ and PHP 7.3+ project. At this time, just geocode is enable in this lib, because my needs is only on this part, but you can open [issues](/issues) to push your needs.

## Installation

To install this lib you can just use composer :

```
composer require puwnz/google-maps-serializer-bundle
```

## Integration

### Bundle registration

```php
<?php
// config/bundles.php

return [
    Puwnz\GoogleMapsSerializerBundle\GoogleMapsSerializerBundle::class => ['all' => true]
];
```

## Example

To use this package on your symfony project, you can use than the next example :

```php
<?php

namespace App\Controller;

use Puwnz\GoogleMapsBundle\Service\GeocodeService;
use Symfony\Component\HttpFoundation\JsonResponse;

class FooController  {    
    public function getGeocodeResult(string $address, GeocodeService $geocodeService) : JsonResponse
    {
        return $this->json($geocodeService->call($address));
    }
}
```

## Testing

The bundle is fully unit tested by [PHPUnit](http://www.phpunit.de/) with a code coverage close to **100%**.

## Contribute

We love contributors! This is an open source project. If you'd like to contribute, feel free to propose a PR!

## License

The Google Map Lib is under the MIT license. For the full copyright and license information, please read the
[LICENSE](/LICENSE) file that was distributed with this source code.
