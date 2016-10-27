<?php

namespace spec\Geomail;

use Geomail\Config\Config;
use Geomail\Email;
use Geomail\Exception\LocationOutOfRangeException;
use Geomail\Geolocation\Location;
use Geomail\Geolocation\Locator;
use Geomail\Geomail;
use Geomail\Mailer\Mailer;
use Geomail\Mailer\Message;
use Geomail\Zip;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GeomailSpec extends ObjectBehavior
{
    function let(Mailer $mailer, Locator $locator, Config $config)
    {
        $this->beConstructedWith('Subject', '<p>Hello</p>', $mailer, $locator, $config);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Geomail::class);
    }

    function it_should_send_an_email_to_the_closest_location_based_on_zip_code(Locator $locator, Mailer $mailer, Config $config)
    {
        $config->isDevMode()->willReturn(false);
        $config->getRange()->willReturn(50);

        $location = [
            'latitude' => '39.766415',
            'longitude' => '-75.112302',
            'email' => 'foo@bar.com',
        ];
        $locations = [$location];

        $locator->closestToZip(Argument::type(Zip::class), Argument::withEveryEntry(Argument::type(Location::class)), 50)->willReturn(Location::fromArray($location));

        $mailer->sendHtml(Argument::that(function (Message $message) {
            return $message->getRecipient() == Email::fromString('foo@bar.com');
        }))->shouldBeCalled();

        $this->sendClosest('08080', $locations);
    }

    function it_should_send_to_the_development_email_in_dev_mode(Locator $locator, Mailer $mailer, Config $config)
    {
        $config->isDevMode()->willReturn(true);
        $config->getRange()->willReturn(50);
        $config->getDevelopmentEmail()->willReturn(Email::fromString('bar@example.com'));

        $location = [
            'latitude' => '39.766415',
            'longitude' => '-75.112302',
            'email' => 'foo@bar.com',
        ];
        $locations = [$location];

        $locator->closestToZip(Argument::type(Zip::class), Argument::withEveryEntry(Argument::type(Location::class)), 50)->willReturn(Location::fromArray($location));

        $mailer->sendHtml(Argument::that(function (Message $message) {
            return $message->getRecipient() == Email::fromString('bar@example.com');
        }))->shouldBeCalled();

        $this->sendClosest('08080', $locations);
    }

    function it_should_send_a_different_message_if_an_out_of_range_message_is_given(Locator $locator, Mailer $mailer, Config $config)
    {

        $config->isDevMode()->willReturn(false);
        $config->getRange()->willReturn(50);

        $location = [
            'latitude' => '34.103003',
            'longitude' => '-118.410468',
            'email' => 'beverlyhills@example.com',
        ];
        $locations = [$location];

        $locator->closestToZip(Argument::type(Zip::class), Argument::withEveryEntry(Argument::type(Location::class)), 50)->willThrow(LocationOutOfRangeException::class);

        $mailer->sendHtml(Argument::that(function (Message $message) {
            return $message->getSubject() === 'Sorry' && $message->getRecipient() == Email::fromString('client@example.com');
        }))->shouldBeCalled();

        $this->sendClosest('08080', $locations, new Message(Email::fromString('client@example.com'), 'Sorry', '<p>Not in range.</p>'));
    }

    function it_should_send_a_different_message_to_the_development_email_if_an_out_of_range_message_is_given_in_dev_mode(Locator $locator, Mailer $mailer, Config $config)
    {
        $config->isDevMode()->willReturn(true);
        $config->getRange()->willReturn(50);
        $config->getDevelopmentEmail()->willReturn(Email::fromString('bar@example.com'));

        $location = [
            'latitude' => '34.103003',
            'longitude' => '-118.410468',
            'email' => 'beverlyhills@example.com',
        ];
        $locations = [$location];

        $locator->closestToZip(Argument::type(Zip::class), Argument::withEveryEntry(Argument::type(Location::class)), 50)->willThrow(LocationOutOfRangeException::class);

        $mailer->sendHtml(Argument::that(function (Message $message) {
            return $message->getSubject() === 'Sorry' && $message->getRecipient() == Email::fromString('bar@example.com');
        }))->shouldBeCalled();

        $this->sendClosest('08080', $locations, new Message(Email::fromString('client@example.com'), 'Sorry', '<p>Not in range.</p>'));
    }

    function it_should_not_send_any_email_if_out_of_range_but_no_message_is_given(Locator $locator, Mailer $mailer, Config $config)
    {
        $config->isDevMode()->willReturn(false);
        $config->getRange()->willReturn(50);
        $config->getDevelopmentEmail()->willReturn(Email::fromString('bar@example.com'));

        $location = [
            'latitude' => '34.103003',
            'longitude' => '-118.410468',
            'email' => 'beverlyhills@example.com',
        ];
        $locations = [$location];

        $locator->closestToZip(Argument::type(Zip::class), Argument::withEveryEntry(Argument::type(Location::class)), 50)->willThrow(LocationOutOfRangeException::class);

        $mailer->sendHtml(Argument::any())->shouldNotBeCalled();

        $this->sendClosest('08080', $locations);
    }

    function it_should_throw_an_exception_if_any_given_locations_cannot_be_converted_to_location_object()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->duringSendClosest(Zip::fromString('08080'), [
            [
                'latitude' => '39.766415',
                'longitude' => '-75.112302',
            ],
        ]);
    }

    function it_should_throw_an_exception_if_no_locations_are_given()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->duringSendClosest('08080', []);
    }

    function it_can_be_created_from_a_prepare_method_using_defaults()
    {
        $config = [
            'google_maps_api_key' => 'foo',
            'range' => 50,
            'mailer_host' => 'smtp.example.org',
            'mailer_port' => 25,
            'mailer_username' => 'user',
            'mailer_password' => 'pass',
            'mailer_from' => 'foo@example.com',
            'development_email' => 'bar@example.com',
        ];

        $this->beConstructedThrough('prepare', ['My Subject', '<p>Hello</p>', $config]);
        $this->shouldHaveType(Geomail::class);
    }
}
