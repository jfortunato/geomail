<?php

namespace spec\Geomail\Geolocation;

use Geomail\Config\Config;
use Geomail\Geolocation\Coordinates;
use Geomail\Geolocation\GoogleMapsPostalCodeTransformer;
use Geomail\Geolocation\Latitude;
use Geomail\Geolocation\Longitude;
use Geomail\Geolocation\PostalCodeTransformer;
use Geomail\PostalCode;
use Geomail\Request\Client;
use PhpSpec\ObjectBehavior;

class GoogleMapsPostalCodeTransformerSpec extends ObjectBehavior
{
    function let(Config $config, Client $client)
    {
        $this->beConstructedWith($config, $client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GoogleMapsPostalCodeTransformer::class);
    }

    function it_is_a_postal_code_transformer()
    {
        $this->shouldHaveType(PostalCodeTransformer::class);
    }

    function it_should_use_the_google_maps_api_to_request_the_lat_lon_of_a_postal_code(Config $config, Client $client)
    {
        $config->getGoogleMapsApiKey()->willReturn('foo');

        $json = json_decode(file_get_contents(__DIR__ . '/responses/zip-request.json'), true);

        $client->json('https://maps.googleapis.com/maps/api/geocode/json?address=08080&key=foo')->willReturn($json);

        $this->toCoordinates(PostalCode::US('08080'))->shouldBeLike(Coordinates::fromLatLon(
            Latitude::fromString('39.7622516'),
            Longitude::fromString('-75.11951069999999')
        ));
    }
}
