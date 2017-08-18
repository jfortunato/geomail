<?php

namespace spec\Geomail\Mailer;

use Geomail\Config\Config;
use Geomail\Email;
use Geomail\Mailer\Mailer;
use Geomail\Mailer\Message;
use Geomail\Mailer\SwiftMailMailer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Swift_Mailer;
use Swift_Message;

class SwiftMailMailerSpec extends ObjectBehavior
{
    function let(Swift_Mailer $mailer, Config $config)
    {
        $this->beConstructedWith($mailer, $config);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SwiftMailMailer::class);
    }

    function it_is_a_mailer()
    {
        $this->shouldHaveType(Mailer::class);
    }

    function it_should_send_an_html_email_using_swift_mailer(Config $config, Swift_Mailer $mailer)
    {
        $config->getMailerFrom()->willReturn(Email::fromString('foo@example.com'));

        $config->getAlwaysSendEmails()->willReturn([Email::fromString('baz@example.com')]);

        $mailer->send(Argument::type(Swift_Message::class))->shouldBeCalled();

        $this->sendHtml(new Message([Email::fromString('bar@example.com')], 'My Subject', '<p>Hello</p>'));
    }
}
