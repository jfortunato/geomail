<?php

namespace spec\Fortunato\Geomail;

use Fortunato\Geomail\Config\Config;
use Fortunato\Geomail\Email;
use Fortunato\Geomail\Factory\GeomailFactory;
use Fortunato\Geomail\Geolocation\Location;
use Fortunato\Geomail\Geolocation\Locator;
use Fortunato\Geomail\Geomail;
use Fortunato\Geomail\Mailer\Mailer;
use Fortunato\Geomail\Mailer\Message;
use Fortunato\Geomail\Zip;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GeomailSpec extends ObjectBehavior
{
    function let(Mailer $mailer, Locator $locator)
    {
        $this->beConstructedWith(new Message('Subject', '<p>Hello</p>'), $mailer, $locator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Geomail::class);
    }

    function it_should_send_an_email_to_the_closest_location_based_on_zip_code(Locator $locator, Mailer $mailer)
    {
        $location = [
            'latitude' => '39.766415',
            'longitude' => '-75.112302',
            'email' => 'foo@bar.com',
        ];
        $locations = [$location];

        $locator->closestToZip(Argument::type(Zip::class), Argument::withEveryEntry(Argument::type(Location::class)))->willReturn(Location::fromArray($location));

        $mailer->sendHtml(Argument::type(Message::class), Email::fromString('foo@bar.com'))->shouldBeCalled();

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

    function it_can_be_created_from_a_prepare_method_using_defaults(Config $config)
    {
        $this->beConstructedThrough('prepare', ['My Subject', '<p>Hello</p>', $config]);
        $this->shouldHaveType(Geomail::class);
    }
}
