<?php

namespace spec\Geomail\Mailer;

use Geomail\Mailer\Message;
use PhpSpec\ObjectBehavior;

class MessageSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Subject', '<p>Hello</p>');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Message::class);
    }

    function it_should_get_the_subject()
    {
        $this->getSubject()->shouldReturn('Subject');
    }

    function it_should_get_the_html()
    {
        $this->getHtml()->shouldReturn('<p>Hello</p>');
    }
}
