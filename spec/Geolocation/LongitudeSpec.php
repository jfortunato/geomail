<?php

namespace spec\Fortunato\Geomail\Geolocation;

use Fortunato\Geomail\Geolocation\Longitude;
use PhpSpec\ObjectBehavior;

class LongitudeSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('fromString', ['-75.112302']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Longitude::class);
    }

    function it_can_be_cast_to_string()
    {
        $this->__toString()->shouldReturn('-75.112302');
    }

    function it_should_throw_an_exception_if_not_given_a_string()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->duringFromString(-75.112302);
    }

    function it_should_throw_an_exception_if_longitude_is_greater_than_bounds()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->duringFromString('181');
    }

    function it_should_throw_an_exception_if_longitude_is_lower_than_bounds()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->duringFromString('-181');
    }
}
