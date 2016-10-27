<?php

namespace spec\Geomail\Parser;

use Geomail\Geolocation\Location;
use Geomail\Parser\ArrayLocationsParser;
use Geomail\Parser\LocationsParser;
use PhpSpec\ObjectBehavior;

class ArrayLocationsParserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ArrayLocationsParser::class);
    }

    function it_is_a_locations_parser()
    {
        $this->shouldHaveType(LocationsParser::class);
    }

    function it_should_parse_an_array()
    {
        $input = [
            [
                'name' => 'Foo',
                'lat' => '39.881709',
                'lon' => '-74.955948',
                'mail' => 'cherryhill@example.com',
            ],
            [
                'name' => 'Bar',
                'lat' => '34.103003',
                'lon' => '-118.410468',
                'mail' => 'beverlyhills@example.com',
            ],
        ];

        $this($input, 'lat', 'lon', 'mail')->shouldBeLike([
            Location::fromArray([
                'latitude' => '39.881709',
                'longitude' => '-74.955948',
                'email' => 'cherryhill@example.com',
            ]),
            Location::fromArray([
                'latitude' => '34.103003',
                'longitude' => '-118.410468',
                'email' => 'beverlyhills@example.com',
            ]),
        ]);
    }
}
