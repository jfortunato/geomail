<?php

namespace Geomail\Request;

interface Client
{
    /**
     * @param string $url
     * @return array
     */
    public function json($url);
}
