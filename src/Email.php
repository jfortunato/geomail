<?php

namespace Fortunato\Geomail;

use InvalidArgumentException;

final class Email
{
    /**
     * @var string
     */
    private $email;

    /**
     * @param string $email
     */
    private function __construct($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("'$email' is not a valid email.");
        }

        $this->email = $email;
    }

    /**
     * @param string $email
     * @return Email
     */
    public static function fromString($email)
    {
        return new Email($email);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->email;
    }
}
