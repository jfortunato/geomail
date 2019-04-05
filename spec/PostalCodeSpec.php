<?php

namespace spec\Geomail;

use Geomail\PostalCode;
use PhpSpec\ObjectBehavior;
use Webmozart\Assert\Assert;

class PostalCodeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PostalCode::class);
    }

    function it_can_be_cast_to_a_string()
    {
        $this->beConstructedThrough('__callStatic', ['US', ['08080']]);
        $this->__toString()->shouldReturn('08080');
        // testing how client code would call it
        Assert::eq((string) PostalCode::US('08080'), '08080');
    }

    function it_throws_an_exception_for_an_unknown_country_code()
    {
        $this->beConstructedThrough('__callStatic', ['XX', ['08080']]);
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    function it_can_determine_a_postal_code()
    {
        $this->beConstructedThrough('determine', ['08080']);
        $this->shouldNotThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    function it_throws_an_exception_if_it_cannot_determine_a_postal_code()
    {
        $this->beConstructedThrough('determine', ['08080-02']);
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    function it_accepts_a_valid_US_postal_code()
    {
        $this->beConstructedThrough('__callStatic', ['US', ['08080']]);
        $this->shouldNotThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    function it_throws_an_exception_if_the_zip_isnt_exactly_5_chars_long()
    {
        $this->beConstructedThrough('__callStatic', ['US', ['08080-02']]);
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    function it_accepts_a_valid_canadian_postal_code()
    {
        $this->beConstructedThrough('__callStatic', ['CA', ['L1Z 0K5']]);
        $this->shouldNotThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    function it_throws_an_exception_for_an_invalid_canadian_postal_code()
    {
        $this->beConstructedThrough('__callStatic', ['CA', ['08080']]);
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }
}
