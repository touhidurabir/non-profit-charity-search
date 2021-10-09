<?php

namespace Touhidurabir\NonProfitCharitySearch\Tests;

use PHPUnit\Framework\TestCase;
use Touhidurabir\NonProfitCharitySearch\CharitySearch;
use Touhidurabir\NonProfitCharitySearch\Search\Search;
use Touhidurabir\NonProfitCharitySearch\Search\Organization;

class CharitySearchTest extends TestCase {

	/** 
	 * @test
	 * @method __construct
	 */
	public function can_be_created_from_valid_query_string() {

		$charitySearch = new CharitySearch('Buff Foundation', ['state[id]'=>'CA']);

		$this->assertInstanceOf(
			CharitySearch::class,
			$charitySearch
		);
	}


	/** 
	 * @test
	 * @method __construct
	 */
	public function can_be_created_without_passing_params_argument() {

		$charitySearch = new CharitySearch('Buff Foundation');

		$this->assertInstanceOf(
			CharitySearch::class,
			$charitySearch
		);
	}


	/** 
	 * @test
	 * @method __construct
	 */
	public function can_be_created_without_passing_any_argument() {

		$charitySearch = new CharitySearch();

		$this->assertInstanceOf(
			CharitySearch::class,
			$charitySearch
		);
	}


	/** 
	 * @test
	 * @method search
	 */
	public function can_be_created_from_static_search_method() {

		$charitySearch = CharitySearch::search('Buff Foundation');

		$this->assertInstanceOf(
			CharitySearch::class,
			$charitySearch
		);


		$charitySearch = CharitySearch::search();
		
		$this->assertInstanceOf(
			CharitySearch::class,
			$charitySearch
		);
	}


	/** 
	 * @test
	 * @method charities
	 */
	public function will_return_search_class_instance() {

		$charitySearch = new CharitySearch('buff', ['state[id]'=>'CA']);

		$this->assertInstanceOf(
			Search::class,
			$charitySearch->charities()
		);
	}


	/** 
	 * @test
	 * @method organization
	 */
	public function will_return_organization_class_instance() {

		$charitySearch = new CharitySearch('142007220');

		$this->assertInstanceOf(
			Organization::class,
			$charitySearch->organization()
		);
	}

}