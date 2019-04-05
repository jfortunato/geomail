<?php

namespace Geomail\Geolocation;

use Geomail\Config\Config;
use Geomail\PostalCode;
use Geomail\Request\Client;

final class GoogleMapsPostalCodeTransformer implements PostalCodeTransformer
{
    /**
     * @var Config
     */
    private $config;
    /**
     * @var Client
     */
    private $client;

    /**
     * @param Config $config
     * @param Client $client
     */
    public function __construct(Config $config, Client $client)
    {
        $this->config = $config;
        $this->client = $client;
    }

    /**
     * @param PostalCode $postalCode
     * @return Coordinates
     */
    public function toCoordinates(PostalCode $postalCode)
    {
        $key = $this->config->getGoogleMapsApiKey();

        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$postalCode&key=$key";

        $json = $this->client->json($url);

        return Coordinates::fromLatLon(
            Latitude::fromString((string) $json['results'][0]['geometry']['location']['lat']),
            Longitude::fromString((string) $json['results'][0]['geometry']['location']['lng'])
        );
    }
}
