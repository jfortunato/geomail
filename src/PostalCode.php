<?php

namespace Geomail;

use InvalidArgumentException;
use Webmozart\Assert\Assert;

class PostalCode
{
    const CODES = [
        'CA' => "/^([ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ]) ?(\d[ABCEGHJKLMNPRSTVWXYZ]\d)$/",
        'US' => "/^\d{5}(-\d{4})?$/",
    ];

    /**
     * @var string
     */
    private $postalCode;

    /**
     * @param string $postalCode
     * @param string $countryCode
     */
    private function __construct(string $postalCode, string $countryCode)
    {
        Assert::keyExists(self::CODES, $countryCode);
        Assert::regex($postalCode, self::CODES[$countryCode]);

        $this->postalCode = $postalCode;
    }

    /**
     * @param $name
     * @param $arguments
     * @return PostalCode
     */
    public static function __callStatic($name, $arguments): PostalCode
    {
        return new PostalCode($arguments[0], $name);
    }

    /**
     * @param string $postalCode
     * @return PostalCode
     */
    public static function determine(string $postalCode): PostalCode
    {
        foreach (self::CODES as $countryCode => $regex) {
            if (preg_match($regex, $postalCode)) {
                return new PostalCode($postalCode, $countryCode);
            }
        }

        throw new InvalidArgumentException("Could not determine country for postal code: '$postalCode'");
    }

    public function __toString()
    {
        return $this->postalCode;
    }
}
