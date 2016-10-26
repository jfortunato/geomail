<?php

namespace spec\Geomail;

use Geomail\Email;
use PhpSpec\ObjectBehavior;

class EmailSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('fromString', ['foo@bar.com']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Email::class);
    }

    function it_can_be_cast_to_string()
    {
        $this->__toString()->shouldReturn('foo@bar.com');
    }

    function it_should_throw_an_exception_if_the_email_is_invalid()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->duringFromString('notanemail');
    }
}
