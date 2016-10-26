<?php

namespace Geomail;

use Webmozart\Assert\Assert;

final class Zip
{
    /**
     * @var string
     */
    private $zip;

    /**
     * @param string $zip
     */
    private function __construct($zip)
    {
        Assert::string($zip);
        Assert::length($zip, 5);

        $this->zip = $zip;
    }

    /**
     * Factory method for creating a Zip value object.
     *
     * @param string $zip
     * @return Zip
     */
    public static function fromString($zip)
    {
        return new Zip($zip);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->zip;
    }
}
