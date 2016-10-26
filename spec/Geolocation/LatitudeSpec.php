<?php

namespace spec\Geomail\Geolocation;

use Geomail\Geolocation\Latitude;
use PhpSpec\ObjectBehavior;

class LatitudeSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('fromString', ['39.766415']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Latitude::class);
    }

    function it_can_be_cast_to_string()
    {
        $this->__toString()->shouldReturn('39.766415');
    }

    function it_should_throw_an_exception_if_not_given_a_string()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->duringFromString(39.766415);
    }

    function it_should_throw_an_exception_if_latitude_is_greater_than_bounds()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->duringFromString('91');
    }

    function it_should_throw_an_exception_if_latitude_is_lower_than_bounds()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->duringFromString('-91');
    }
}
