<?php

namespace Touhidurabir\NonProfitCharitySearch\Tests\Search;

use InvalidArgumentException;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Touhidurabir\NonProfitCharitySearch\Exceptions\OrganizationRequestException;
use Touhidurabir\NonProfitCharitySearch\Search\Organization;
use Touhidurabir\NonProfitCharitySearch\Tests\Mocks\Concerns\GuzzleMock;

class OrganizationTest extends TestCase {

	use GuzzleMock;

	/** 
	 * @test
	 * @method __construct
	 */
	public function can_not_be_created_from_invalid_ein() {

		$this->expectException(InvalidArgumentException::class);

		new Organization('invalid');
	}


	/** 
	 * @test
	 * @method __construct
	 */
	public function can_not_be_created_if_lenght_not_equal_to_9() {

		$this->expectException(InvalidArgumentException::class);

		new Organization('123456');
	}


	/** 
	 * @test
	 * @method __construct
	 */
	public function can_be_created_from_a_valid_ein_string() {

		$this->assertInstanceOf(
			Organization::class,
			new Organization('123456789')
		);
	}


	/** 
	 * @test
	 * @method __construct
	 */
	public function can_be_created_from_a_valid_ein_integer() {

		$this->assertInstanceOf(
			Organization::class,
			new Organization('123456789')
		);
	}


	/** 
	 * @test
	 * @method getGenratedApiUrl
	 */
	public function will_return_proper_generated_api_url_from_given_ein() {

		$url = 'https://projects.propublica.org/nonprofits/api/v2/organizations/123456789.json';

		$organization = new Organization('123456789');

		$this->assertSame($url, $organization->getGenratedApiUrl());
	}


	/** 
	 * @test
	 * @method getResult
	 */
	public function will_always_return_json_response_on_success_request() {

        $client = $this->mockBuilder([new Response(200, [], '{}')]);

		$response = (new Organization('142007220'))->getResult($client);

		$this->assertJson($response);
	}


	/** 
	 * @test
	 * @method getResult
	 */
	public function will_throw_exception_on_no_result_found() {

		$this->expectException(OrganizationRequestException::class);

        $client = $this->mockBuilder([new OrganizationRequestException]);

		(new Organization('123456789'))->getResult($client);
	}
}