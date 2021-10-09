<?php

namespace Touhidurabir\NonProfitCharitySearch\Search;

use Exception;
use InvalidArgumentException;
use GuzzleHttp\Client;
use Touhidurabir\NonProfitCharitySearch\Contracts\CharityContract;
use Touhidurabir\NonProfitCharitySearch\HttpRequest\HttpRequest;
use Touhidurabir\NonProfitCharitySearch\Exceptions\OrganizationRequestException;

class Organization implements CharityContract {

	/**
     * The Base API Endpont to hit to get response
     *
     * @var const
     */
	const API_ENDPOINT = 'https://projects.propublica.org/nonprofits/api/v2/organizations/{ORG_EIN}.json';


	/**
     * provided EIN to get organization details
     *
     * @var mixed [string|int]
     */
	protected $ein;


	/**
     * Final build api url 
     *
     * @var string
     */
	protected $url;


	/**
     * Create a new organization instance.
     *
     * @param  mixed $ein
     * @return void
     */
	public function __construct($ein = null) {

		$this->ein = $this->ensureIsValidEin($ein);

		$this->url = $this->constructApiEndPointUrl();
	}


	/**
     * Return the final api url with query string
     *
     * @return string
     */
	public function getGenratedApiUrl(): string {

		return $this->url;
	}


	/**
     * Get the organization result
     *
     * @param  Client    $client
     * @throws OrganizationRequestException
     *
     * @return string
     */
	public function getResult(Client $client = null): string {

		try {
			
			$httpRequest = new HttpRequest($this->url, $client);

			return $httpRequest->getResult();	

		} catch (Exception $exception) {
			 
			 throw new OrganizationRequestException(
			 	$exception->getMessage(),
			 	$exception->getCode(),
			 	$exception
			 );
		}
		
	}


	/**
     * Construct the final api url.
     *
     * Use the following properties to build the final url
     * @uses const API_ENDPOINT
     * @uses mixed $ein
     *
     * @return string
     */
	protected function constructApiEndPointUrl(): string {

		return str_replace('{ORG_EIN}', $this->ein, self::API_ENDPOINT);
	}


	/**
     * Validate the EIN
     *
     * @param  mixed     $ein
     * @throws InvalidArgumentException
     *
     * @return mixed [string|int]
     */
	protected function ensureIsValidEin($ein) {

		if ( !ctype_digit($ein) || strlen((string)$ein) !== 9 ) {
			throw new InvalidArgumentException(
				sprintf(
					'"%s" is not a valid EIN number',
					$ein
				)
			);
		}

		return $ein;
	}
}