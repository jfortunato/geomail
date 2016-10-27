<?php

namespace spec\Geomail\Parser;

use Geomail\Geolocation\Location;
use Geomail\Parser\JsonLocationsParser;
use Geomail\Parser\LocationsParser;
use PhpSpec\ObjectBehavior;

class JsonLocationsParserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(JsonLocationsParser::class);
    }

    function it_is_a_locations_parser()
    {
        $this->shouldHaveType(LocationsParser::class);
    }

    function it_should_parse_a_json_file()
    {
        $this(__DIR__ . '/locations/locations.json', 'lat', 'lon', 'mail')->shouldBeLike([
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
