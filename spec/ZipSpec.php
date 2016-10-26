<?php

namespace spec\Fortunato\Geomail;

use Fortunato\Geomail\Zip;
use PhpSpec\ObjectBehavior;

class ZipSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('fromString', ['08080']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Zip::class);
    }

    function it_can_be_cast_to_string()
    {
        $this->__toString()->shouldReturn('08080');
    }

    function it_throws_an_exception_if_the_zip_if_not_a_string()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->duringFromString(90210);
    }

    function it_throws_an_exception_if_the_zip_isnt_exactly_5_chars_long()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->duringFromString('08080-02');
    }
}
