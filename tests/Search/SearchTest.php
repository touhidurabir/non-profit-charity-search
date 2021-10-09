<?php

namespace Touhidurabir\NonProfitCharitySearch\Tests\Search;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Touhidurabir\NonProfitCharitySearch\Search\Search;
use Touhidurabir\NonProfitCharitySearch\Exceptions\SearchException;
use Touhidurabir\NonProfitCharitySearch\Tests\Mocks\Concerns\GuzzleMock;

class SearchTest extends TestCase {

	use GuzzleMock;

	/** 
	 * @test
	 * @method __construct
	 */
	public function can_be_created_from_empty_parameters() {

		$this->assertInstanceOf(
			Search::class,
			new Search()
		);
	}


	/** 
	 * @test
	 * @method getResult
	 */
	public function will_always_return_json_response_on_success_request() {

		$client = $this->mockBuilder([new Response(200, [], '{}')]);

		$response = (new Search('buff'))->getResult($client);

		$this->assertJson($response);
	}


	/** 
	 * @test
	 * @method getResult
	 */
	public function will_throw_exception_on_no_result_found() {

		$this->expectException(SearchException::class);

        $client = $this->mockBuilder([new SearchException]);

		(new Search('123456789'))->getResult($client);
	}


	/** 
	 * @test
	 * @method getGenratedApiUrl
	 */
	public function will_return_proper_api_url_if_no_parameter_given() {

		$url = 'https://projects.propublica.org/nonprofits/api/v2/search.json';

		$this->assertSame($url, (new Search())->getGenratedApiUrl());
	}


	/** 
	 * @test
	 * @method getGenratedApiUrl
	 */
	public function will_return_proper_api_url_if_parameter_given() {

		$url = 'https://projects.propublica.org/nonprofits/api/v2/search.json?q=buff&page=1&state%5Bid%5D=CA';

		$this->assertSame(
			$url, 
			(new Search('buff', ['page'=>1, 'state[id]'=>'CA']))->getGenratedApiUrl()
		);
	}

	
	/** 
	 * @test
	 * @method setState
	 */
	public function will_set_state_if_proper_state_code_given() {

		$params = (New Search('buff'))->setState('ny')->getQueryParams();

		$this->assertArrayHasKey('state[id]', $params);
    	$this->assertSame('NY', $params['state[id]']);
	}

	
	/** 
	 * @test
	 * @method setState
	 */
	public function will_not_set_state_if_invalid_state_code_given() {

		$params = (New Search('buff'))->setState('some code')->getQueryParams();

		$this->assertArrayNotHasKey('state[id]', $params);
	}	


	/** 
	 * @test
	 * @method setState
	 */
	public function will_not_set_state_if_no_state_code_given() {

		$params = (New Search('buff'))->setState()->getQueryParams();

		$this->assertArrayNotHasKey('state[id]', $params);
	}


	/** 
	 * @test
	 * @method setPage
	 */
	public function will_set_page_if_proper_page_number_given() {

		$params = (New Search('buff'))->setPage(2)->getQueryParams();

		$this->assertArrayHasKey('page', $params);
    	$this->assertSame(2, $params['page']);
	}


	/** 
	 * @test
	 * @method setPage
	 */
	public function will_set_page_to_default_0_if_no_page_number_given() {

		$params = (New Search('buff'))->setPage()->getQueryParams();

		$this->assertArrayHasKey('page', $params);
    	$this->assertSame(0, $params['page']);
	}


	/** 
	 * @test
	 * @method setNtee
	 */
	public function will_set_ntee_if_proper_value_given() {

		$params = (New Search('buff'))->setNtee(1)->getQueryParams();

		$this->assertArrayHasKey('ntee[id]', $params);
    	$this->assertSame(1, $params['ntee[id]']);
	}


	/** 
	 * @test
	 * @method setNtee
	 */
	public function will_not_set_ntee_if_no_value_given() {

		$params = (New Search('buff'))->setNtee()->getQueryParams();

		$this->assertArrayNotHasKey('ntee[id]', $params);
	}


	/** 
	 * @test
	 * @method setCcode
	 */
	public function will_set_ccode_if_proper_value_given() {

		$params = (New Search('buff'))->setCcode(1)->getQueryParams();

		$this->assertArrayHasKey('c_code[id]', $params);
    	$this->assertSame(1, $params['c_code[id]']);
	}


	/** 
	 * @test
	 * @method setCcode
	 */
	public function will_not_set_ccode_if_no_value_given() {

		$params = (New Search('buff'))->setCcode()->getQueryParams();

		$this->assertArrayNotHasKey('c_code[id]', $params);
	}

	
	/** 
	 * @test
	 * @method addQueryParams
	 */
	public function will_add_given_params_to_query_params() {

		$queryParams = ['page' => 1, 'c_code[id]' => 1, 'state[id]' => 'NY', 'val' => 'val'];

		$params = (New Search('buff', ['ntee[id]' => 1]))
				      ->addQueryParams($queryParams)
				      ->getQueryParams();

		$this->assertEquals(
			array_merge($queryParams, ['ntee[id]' => 1]), 
			$params
		);
	}


	/** 
	 * @test
	 * @method getCurrentPage
	 */
	public function will_return_current_page_numebr() {

		$client = $this->mockBuilder([
        	new Response(200, [], '{}'),
            new Response(200, [], '{}')
        ]);

		$search = (New Search(null, ['page' => 1]));
		$this->assertSame(1, $search->getCurrentPage());

		$search->setPage(2);
		$this->assertSame(2, $search->getCurrentPage());

		$search->next($client);
		$this->assertSame(3, $search->getCurrentPage());
	}


	/** 
	 * @test
	 * @method next
	 */
	public function will_update_the_page_number_on_next_call() {

        $client = $this->mockBuilder([
        	new Response(200, [], '{}'),
            new Response(200, [], '{}')
        ]);

		$search = New Search();

		$search->next($client);
		$this->assertStringContainsString('page=1', $search->getGenratedApiUrl());

		$search->next($client);
		$this->assertStringContainsString('page=2', $search->getGenratedApiUrl());
	}

}