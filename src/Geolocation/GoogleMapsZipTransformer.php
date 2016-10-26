<?php

namespace Fortunato\Geomail\Geolocation;

use Fortunato\Geomail\Config\Config;
use Fortunato\Geomail\Request\Client;
use Fortunato\Geomail\Zip;

final class GoogleMapsZipTransformer implements ZipTransformer
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
     * @param Zip $zip
     * @return Coordinates
     */
    public function toCoordinates(Zip $zip)
    {
        $key = $this->config->getGoogleMapsApiKey();

        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$zip&key=$key";

        $json = $this->client->json($url);

        return Coordinates::fromLatLon(
            Latitude::fromString((string) $json['results'][0]['geometry']['location']['lat']),
            Longitude::fromString((string) $json['results'][0]['geometry']['location']['lng'])
        );
    }
}
