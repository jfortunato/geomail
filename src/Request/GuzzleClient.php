<?php

namespace Geomail\Request;

use GuzzleHttp\Client as Guzzle;

final class GuzzleClient implements Client
{
    /**
     * @var Guzzle
     */
    private $guzzle;

    /**
     * @param Guzzle $guzzle
     */
    public function __construct(Guzzle $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    /**
     * @param string $url
     * @return array
     */
    public function json($url)
    {
        return json_decode($this->guzzle->get($url)->getBody()->getContents(), true);
    }
}
