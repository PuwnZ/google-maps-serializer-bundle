<?php

declare(strict_types=1);

namespace Puwnz\GoogleMapsSerializerBundle\Serializer;

use Puwnz\GoogleMapsLib\Geocode\DTO\GeocodeAddressComponent;
use Puwnz\GoogleMapsLib\Geocode\DTO\GeocodeResult;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class GeocodeSerializer implements ContextAwareNormalizerInterface
{
    public function supportsNormalization($data, $format = null, array $context = []) : bool
    {
        return $data instanceof GeocodeResult;
    }

    /**
     * @param GeocodeResult $object
     */
    public function normalize($object, $format = null, array $context = []) : array
    {
        $geocodeGeometry = $object->getGeometry();
        $geometryLocation = $geocodeGeometry->getLocation();
        $geocodeAddressComponents = $object->getGeocodeAddressComponents();

        return [
            'address' => $object->getFormattedAddress(),
            'place_id' => $object->getPlaceId(),
            'partial' => $object->isPartialMatch(),
            'types' => $object->getTypes(),
            'components' => \array_map([$this, 'parseComponents'], $geocodeAddressComponents),
            'geometry' => [
                'lat' => $geometryLocation->getLatitude(),
                'lng' => $geometryLocation->getLongitude(),
            ],
        ];
    }

    private function parseComponents(GeocodeAddressComponent $component) : array
    {
        return [
            'types' => $component->getTypes(),
            'long_name' => $component->getLongName(),
            'short_name' => $component->getShortName(),
        ];
    }
}
