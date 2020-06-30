<?php

declare(strict_types=1);

namespace Puwnz\GoogleMapsSerializerBundle\Tests\Serializer;

use PHPUnit\Framework\TestCase;
use Puwnz\GoogleMapsLib\Geocode\DTO\GeocodeAddressComponent;
use Puwnz\GoogleMapsLib\Geocode\DTO\GeocodeGeometry;
use Puwnz\GoogleMapsLib\Geocode\DTO\GeocodeResult;
use Puwnz\GoogleMapsLib\Geocode\DTO\Geometry\GeometryLocation;
use Puwnz\GoogleMapsSerializerBundle\Serializer\GeocodeSerializer;

class GeocodeSerializerTest extends TestCase
{
    /** @var GeocodeSerializer */
    private $service;

    protected function setUp() : void
    {
        parent::setUp();

        $this->service = new GeocodeSerializer();
    }

    public function supportsProvider() : array
    {
        return [
            [$this->createMock(GeocodeResult::class), true],
            [new \stdClass(), false],
        ];
    }

    /**
     * @dataProvider supportsProvider
     */
    public function testSupportsNormalization($data, bool $expected) : void
    {
        $actual = $this->service->supportsNormalization($data);

        TestCase::assertSame($expected, $actual);
    }

    public function testNormalize() : void
    {
        $object = new GeocodeResult();
        $geometry = new GeocodeGeometry();
        $location = new GeometryLocation();
        $geocodeAddressComponents = new GeocodeAddressComponent();

        $object->setGeocodeAddressComponent($geocodeAddressComponents);
        $object->setFormattedAddress('mocked-address');
        $object->setPlaceId('mocked-place_id');
        $object->setPartialMatch(false);
        $object->setTypes('mocked-type');
        $geocodeAddressComponents->setTypes('mocked-address_type');
        $geocodeAddressComponents->setLongName('mocked-long_name');
        $geocodeAddressComponents->setShortName('mocked-short_name');

        $location->setLatitude(0.0);
        $location->setLongitude(0.0);

        $geometry->setLocation($location);
        $object->setGeometry($geometry);

        $actual = $this->service->normalize($object);
        $expected = [
            'address' => 'mocked-address',
            'place_id' => 'mocked-place_id',
            'partial' => false,
            'types' => [
                'mocked-type',
            ],
            'components' => [
                [
                    'types' => [
                        'mocked-address_type',
                    ],
                    'long_name' => 'mocked-long_name',
                    'short_name' => 'mocked-short_name',
                ],
            ],
            'geometry' => [
                'lat' => 0.0,
                'lng' => 0.0,
            ],
        ];

        TestCase::assertSame($expected, $actual);
    }
}
