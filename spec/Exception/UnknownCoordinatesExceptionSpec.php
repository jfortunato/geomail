<?php

namespace spec\Geomail\Exception;

use Geomail\Exception\UnknownCoordinatesException;
use Geomail\PostalCode;
use PhpSpec\ObjectBehavior;

class UnknownCoordinatesExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(PostalCode::US('99999'));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UnknownCoordinatesException::class);
    }

    function it_is_an_exception()
    {
        $this->shouldHaveType(\Exception::class);
    }

    function it_should_get_the_message()
    {
        $this->getMessage()->shouldReturn("Could not find coordinates for '99999'.");
    }
}
