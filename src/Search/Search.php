<?php

namespace Touhidurabir\NonProfitCharitySearch\Search;

use Exception;
use GuzzleHttp\Client;
use Touhidurabir\NonProfitCharitySearch\HttpRequest\HttpRequest;
use Touhidurabir\NonProfitCharitySearch\Contracts\CharityContract;
use Touhidurabir\NonProfitCharitySearch\Exceptions\SearchException;

class Search implements CharityContract {

	/**
     * The API Endpont to hit to get response
     *
     * @var const
     */
	const API_ENDPOINT = 'https://projects.propublica.org/nonprofits/api/v2/search.json';

	
	/**
     * The search query string
     *
     * @var string
     */
	protected $query;

	
	/**
     * Search page number
     *
     * @var int
     */
	protected $page = 0;


	/**
     * Search query params
     *
     * @var array
     */
	protected $queryParams = [];


	/**
     * List of valid US state codes
     *
     * @var array
     */
	protected $states = [ 'AK', 'AL', 'AR', 'AZ', 'CA', 'CO', 'CT', 'DC', 'DE', 'FL', 'GA', 'HI', 'IA', 'ID', 'IL', 'IN', 'KS', 'KY', 'LA', 'MA', 'MD', 'ME', 'MI', 'MN', 'MO', 'MS', 'MT', 'NC', 'ND', 'NE', 'NH', 'NJ', 'NM', 'NV', 'NY', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VA', 'VT', 'WA', 'WI', 'WV', 'WY'
	];


	/**
     * Create a new search instance.
     *
     * @param  string $query
     * @param  array  $params
     *
     * @return void
     */
	public function __construct(string $query = null, array $params = []) {

		$this->query = $query;

		$this->queryParams = $params;

		!isset($params['page']) ?: $this->setPage($params['page']);
	}

	
	/**
     * Get the search result
     *
     * @param  Client    $client
     * @throws SearchException 
     *
     * @return string
     */
	public function getResult(Client $client = null): string {

		try {
			
			$httpRequest = new HttpRequest(self::API_ENDPOINT, $client);

			return $httpRequest->getResult($this->buildQueryParamStructure());	

		} catch (Exception $exception) {
			 
			 throw new SearchException(
			 	$exception->getMessage(),
			 	$exception->getCode(),
			 	$exception
			 );
		}
	}


	/**
     * Get the next search result
     *
     * @param  Client $client
     * @return string
     */
	public function next(Client $client = null): string {

		return
			$this->setPage($this->page + 1)
				 ->getResult($client);

	}


	/**
     * Return current search page number
     *
     * @return int
     */
	public function getCurrentPage(): int {

		return $this->page;
	}


	/**
     * Return the final api url with query string
     *
     * @return string
     */
	public function getGenratedApiUrl(): string {

		$queryString = $this->buildQueryString();

		return
			empty($queryString)
				? self::API_ENDPOINT
				: self::API_ENDPOINT . '?' . $queryString;
	}


	/**
     * Set the state
     *
     * @param  string $code
     * @return self
     */
	public function setState(string $code = null): self  {

		$code = strtoupper(trim($code));

		! in_array($code, $this->states) ?: $this->addQueryParams(['state[id]' => $code]);

		return $this;
	}


	/**
     * Set search page number
     *
     * @param  int $page
     * @return self
     */
	public function setPage(int $page = null): self {

		$this->page = $page ?? $this->page;

		$this->addQueryParams(['page' => $this->page]);

		return $this;
	}


	/**
     * Set the NTEE code
     *
     * @param  int $id
     * @return self
     */
	public function setNtee(int $id = null): self {

		is_null($id) ?: $this->addQueryParams(['ntee[id]' => $id]);

		return $this;
	}


	/**
     * Set the C Code
     *
     * @param  int $id
     * @return self
     */
	public function setCcode(int $id = null): self {

		is_null($id) ?: $this->addQueryParams(['c_code[id]' => $id]);

		return $this;
	}


	/**
     * Update the query params
     *
     * @param  array $params
     * @return self
     */
	public function addQueryParams(array $params = []): self {
		
		foreach ($params as $key => $value) {
			
			$this->queryParams[$key] = $value;
		}

		return $this;
	}


	/**
     * Get the current query params
     *
     * @return array
     */
	public function getQueryParams(): array {
		
		return $this->queryParams;
	}


	/**
     * Build final query param to make the api request
     *
     * @return array
     */
	protected function buildQueryParamStructure(): array {

		return
			array_filter(
				array_merge(['q' => $this->query], $this->queryParams), function($v) { 
					return !is_null($v); 
				}
			);

	}


	/**
     * Generte the query string
     *
     * @return string
     */
	protected function buildQueryString(): string {

		return trim( http_build_query($this->buildQueryParamStructure()) );

	}


}