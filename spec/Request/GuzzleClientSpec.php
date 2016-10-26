<?php

namespace spec\Geomail\Request;

use Geomail\Request\Client;
use Geomail\Request\GuzzleClient;
use GuzzleHttp\Client as Guzzle;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class GuzzleClientSpec extends ObjectBehavior
{
    function let(Guzzle $guzzle)
    {
        $this->beConstructedWith($guzzle);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GuzzleClient::class);
    }

    function it_is_a_client()
    {
        $this->shouldHaveType(Client::class);
    }

    function it_should_use_guzzle_to_return_a_json_response(Guzzle $guzzle, ResponseInterface $response, StreamInterface $stream)
    {
        $guzzle->get('http://httpbin.org/get')->willReturn($response);

        $response->getBody()->willReturn($stream);
        $stream->getContents()->willReturn('{"foo":"bar"}');

        $this->json('http://httpbin.org/get')->shouldReturn(['foo' => 'bar']);
    }
}
