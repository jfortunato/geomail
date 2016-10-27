<?php

namespace spec\Geomail\Exception;

use Geomail\Exception\LocationOutOfRangeException;
use PhpSpec\ObjectBehavior;

class LocationOutOfRangeExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(50);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LocationOutOfRangeException::class);
    }

    function it_is_an_exception()
    {
        $this->shouldHaveType(\Exception::class);
    }

    function it_should_get_the_message()
    {
        $this->getMessage()->shouldReturn('There are no locations within 50 miles.');
    }
}
