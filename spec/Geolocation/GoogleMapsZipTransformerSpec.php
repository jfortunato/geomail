<?php

namespace spec\Fortunato\Geomail\Geolocation;

use Fortunato\Geomail\Config\Config;
use Fortunato\Geomail\Geolocation\Coordinates;
use Fortunato\Geomail\Geolocation\GoogleMapsZipTransformer;
use Fortunato\Geomail\Geolocation\Latitude;
use Fortunato\Geomail\Geolocation\Longitude;
use Fortunato\Geomail\Geolocation\ZipTransformer;
use Fortunato\Geomail\Request\Client;
use Fortunato\Geomail\Zip;
use PhpSpec\ObjectBehavior;

class GoogleMapsZipTransformerSpec extends ObjectBehavior
{
    function let(Config $config, Client $client)
    {
        $this->beConstructedWith($config, $client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GoogleMapsZipTransformer::class);
    }

    function it_is_a_zip_transformer()
    {
        $this->shouldHaveType(ZipTransformer::class);
    }

    function it_should_use_the_google_maps_api_to_request_the_lat_lon_of_a_zip(Config $config, Client $client)
    {
        $config->getGoogleMapsApiKey()->willReturn('foo');

        $json = json_decode(file_get_contents(__DIR__ . '/responses/zip-request.json'), true);

        $client->json('https://maps.googleapis.com/maps/api/geocode/json?address=08080&key=foo')->willReturn($json);

        $this->toCoordinates(Zip::fromString('08080'))->shouldBeLike(Coordinates::fromLatLon(
            Latitude::fromString('39.7622516'),
            Longitude::fromString('-75.11951069999999')
        ));
    }
}
