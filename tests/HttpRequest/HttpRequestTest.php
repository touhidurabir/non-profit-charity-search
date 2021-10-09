<?php

namespace Touhidurabir\NonProfitCharitySearch\Tests\HttpRequest;

use InvalidArgumentException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\TestCase;
use Touhidurabir\NonProfitCharitySearch\HttpRequest\HttpRequest;
use Touhidurabir\NonProfitCharitySearch\Tests\Mocks\Concerns\GuzzleMock;

class HttpRequestTest extends TestCase {

	use GuzzleMock;

	/** 
	 * @test
	 * @method __construct
	 */
	public function can_not_be_created_from_invalid_url() {

		$this->expectException(InvalidArgumentException::class);

		new HttpRequest('invalid');
	}


	/** 
	 * @test
	 * @method __construct
	 */
	public function can_be_created_from_valid_url() {

		$url = 'https://projects.propublica.org/nonprofits/api/v2/search.json?q=buff';

		$this->assertInstanceOf(
			HttpRequest::class, 
			new HttpRequest($url)
		);
	}


	/** 
	 * @test
	 * @method getResult
	 */
	public function will_always_return_a_json_response_on_success_request() {

		$url = 'https://projects.propublica.org/nonprofits/api/v2/search.json?q=buff';

		$client = $this->mockBuilder([new Response(200, [], '{}')]);

		$response = (new HttpRequest($url, $client))->getResult();

		$this->assertJson($response);
	}


	/** 
	 * @test
	 * @method getResult
	 */
	// public function will_throw_exception_on_failed_request() {

	// 	$this->expectException(ClientException::class);

	// 	$url = 'https://projects.propublica.org/nonprofits/api/v2/organizations/01-1234567.json';

    //     $client = $this->mockBuilder(
    //     	[new ClientException("404 Not Found", new Request('GET', $url))]
    //     );

	// 	(new HttpRequest($url, $client))->getResult();
	// }

}
