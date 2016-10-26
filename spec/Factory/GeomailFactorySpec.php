<?php

namespace spec\Geomail\Factory;

use Geomail\Factory\GeomailFactory;
use PhpSpec\ObjectBehavior;

class GeomailFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(GeomailFactory::class);
    }
}
