<?php

namespace spec\Geomail\Config;

use Geomail\Config\Config;
use Geomail\Email;
use PhpSpec\ObjectBehavior;

class ConfigSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('fromArray', [[
            'google_maps_api_key' => 'foo',
            'mailer_host' => 'smtp.example.org',
            'mailer_port' => 25,
            'mailer_username' => 'user',
            'mailer_password' => 'pass',
            'mailer_from' => 'foo@example.com',
        ]]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Config::class);
    }

    function it_should_get_the_google_maps_api_key()
    {
        $this->getGoogleMapsApiKey()->shouldReturn('foo');
    }

    function it_should_get_the_mailer_host()
    {
        $this->getMailerHost()->shouldReturn('smtp.example.org');
    }

    function it_should_get_the_mailer_port()
    {
        $this->getMailerPort()->shouldReturn(25);
    }

    function it_should_get_the_mailer_username()
    {
        $this->getMailerUsername()->shouldReturn('user');
    }

    function it_should_get_the_mailer_password()
    {
        $this->getMailerPassword()->shouldReturn('pass');
    }

    function it_should_get_the_mailer_from()
    {
        $this->getMailerFrom()->shouldBeLike(Email::fromString('foo@example.com'));
    }
}
