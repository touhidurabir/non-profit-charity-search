<?php

namespace Touhidurabir\NonProfitCharitySearch;

use Touhidurabir\NonProfitCharitySearch\Search\Search;
use Touhidurabir\NonProfitCharitySearch\Search\Organization;

class CharitySearch {

	/**
     * The search query string
     *
     * @var string
     */
	protected $query;


	/**
     * Search query params
     *
     * @var array
     */
	protected $queryParams;


	/**
     * Create a new CharitySearch instance.
     *
     * @param  string $query
     * @param  array  $params
     *
     * @return void
     */
	public function __construct(string $query = null, array $params = []) {

		$this->query = $query;

		$this->queryParams = $params;
	}


	/**
     * Static method to create a new CharitySearch instance.
     *
     * @param  string $query
     * @param  array  $params
     *
     * @return self
     */
	public static function search(string $query = null, array $params = []): self {

		return new static($query, $params);
	}

	
	/**
     * Return a new Search
     *
     * @return Search
     */
	public function charities(): Search {

		return new Search($this->query, $this->queryParams);
	}


	/**
     * Return a new Organization
     *
     * @return Organization
     */
	public function organization(): Organization {

		return new Organization($this->query);
	}

}