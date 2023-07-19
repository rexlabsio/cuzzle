<?php

namespace Tests\Middleware;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Namshi\Cuzzle\Middleware\CurlFormatterMiddleware;
use PHPUnit\Framework\TestCase;
use Tests\Support\TestLogger;

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

        $this->assertTrue($logger->hasRecordThatContains('curl', 'debug'));
    }
}
