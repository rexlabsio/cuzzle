<?php

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use Namshi\Cuzzle\Middleware\CurlFormatterMiddleware;
use PHPUnit\Framework\TestCase;
use Psr\Log\Test\TestLogger;

class CurlFormatterMiddlewareTest extends TestCase
{
    public function testGet()
    {
        $mock = new MockHandler([new Response(204)]);
        $handler = HandlerStack::create($mock);
        $logger = new TestLogger();

        $handler->after('cookies', new CurlFormatterMiddleware($logger));
        $client = new Client(['handler' => $handler]);

        $client->get('http://google.com');

        $this->assertTrue($logger->hasDebugThatContains('curl'));
    }
}
