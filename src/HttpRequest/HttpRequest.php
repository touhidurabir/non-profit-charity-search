<?php

namespace Touhidurabir\NonProfitCharitySearch\HttpRequest;

use InvalidArgumentException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class HttpRequest {

	/**
     * URL to get response
     *
     * @var string
     */
	public $url;


	/**
     * GuzzleHttp Client
     *
     * @var object
     */
	protected $client;


	/**
     * Create a new HttpRequest instance.
     *
     * @param  string $url
     * @param  Client $client
     *
     * @return void
     */
	public function __construct(string $url, Client $client = null) {

		$this->url = $this->ensureIsValidUrl($url);

		$this->client = $client ?: new Client();
	}


	/**
     * Get the response from api request
     *
     * @param  array $queryParams
     * @return string
     */
	public function getResult(array $queryParams = []): string {

		$response = $this->client
						 ->get(
						 	$this->url,
						 	['query' => $queryParams]
						 );

		return $response->getBody()->getContents();
	}


	/**
     * Validate URL
     *
     * @param  string    $url
     * @throws InvalidArgumentException
     *
     * @return string
     */
	protected function ensureIsValidUrl(string $url): string {

		if ( ! filter_var($url, FILTER_VALIDATE_URL) ) {
			throw new InvalidArgumentException(
				sprintf(
					'"%s" is not a valid URL',
					$url
				)
			);
		}

		return $url;
	}

}