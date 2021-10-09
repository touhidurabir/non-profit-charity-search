<?php

namespace Touhidurabir\NonProfitCharitySearch\Tests\Mocks\Concerns;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ClientException;

trait GuzzleMock {

	/**
     * Build the Mock Client
     *
     * @param  array $mocks
     * @return Client
     */
	protected function mockBuilder(array $mocks): Client {

		$mock    = new MockHandler($mocks);

        $handler = HandlerStack::create($mock);

        $client  = new Client(['handler' => $handler]);

        return $client;
	}
}