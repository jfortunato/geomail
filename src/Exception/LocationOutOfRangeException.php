<?php

namespace Geomail\Exception;

class LocationOutOfRangeException extends \Exception
{
    /**
     * @param integer $miles
     */
    public function __construct($miles)
    {
        parent::__construct("There are no locations within $miles miles.");
    }
}
