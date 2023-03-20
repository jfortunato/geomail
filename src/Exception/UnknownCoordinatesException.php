<?php

namespace Geomail\Exception;

use Geomail\PostalCode;

class UnknownCoordinatesException extends \Exception
{
    /**
     * @param PostalCode $postalCode
     */
    public function __construct(PostalCode $postalCode)
    {
        parent::__construct("Could not find coordinates for '$postalCode'.");
    }
}
