<?php

namespace Touhidurabir\NonProfitCharitySearch\Tests\LaravelTest;

use GuzzleHttp\Psr7\Response;
use Orchestra\Testbench\TestCase;
use Touhidurabir\NonProfitCharitySearch\Facades\NonProfitCharitySearch;
use Touhidurabir\NonProfitCharitySearch\Tests\LaravelTest\Concerns\LaravelTestBootstrapping;
use Touhidurabir\NonProfitCharitySearch\Tests\Mocks\Concerns\GuzzleMock;

// vendor/laravel/framework/src/Illuminate/Encryption/EncryptionServiceProvider.php

class RouteTest extends TestCase {

	/** 
	 * Load laravel test specific bootstrapping methods
	 */
	use LaravelTestBootstrapping;


	/** 
	 * Provide GuzzleHttp mock client
	 */
	use GuzzleMock;
	

    /** 
	 * @test
	 * 
	 */
    // public function the_search_route_can_be_accessed_as_get_request() {

    // 	$client = $this->mockBuilder([new Response(200, [], '{}')]);

    // 	$search = \Mockery::mock('overload:Touhidurabir\NonProfitCharitySearch\Search\Search')->makePartial();
    // 	$search->shouldReceive('getResult')
    // 		   // ->with($client)
    // 		   ->once()
    // 		   // ->shouldReceive('getResult')
    //            ->andReturn('{}');

    //     // NonProfitCharitySearch::search()->charities();

    // 	$this->get('/charity-search/search')
    // 		 ->assertViewIs('charity-search::charities')
    // 		 ->assertViewHas('response', ['data'=>[], 'message'=>'search completed', 'status'=>'success'])
    //          ->assertStatus(200);
    // }


    /** 
	 * @test
	 * 
	 */
    public function the_search_route_can_be_accessed_as_post_request() {

    	// $search = \Mockery::mock('overload:Touhidurabir\NonProfitCharitySearch\Search\Search');
    	// $search->shouldReceive('getResult')
    	// 	   ->once()
        //        ->andReturn('{}');

    	$this->post('/charity-search/search', ['_token' => csrf_token()])
    		 ->assertJson([])
             ->assertStatus(200);
    }


    /** 
	 * @test
	 * 
	 */
    public function the_organization_route_can_be_accessed_as_get_request() {

    	// $search = \Mockery::mock('overload:Touhidurabir\NonProfitCharitySearch\Search\Organization');
    	// $search->shouldReceive('getResult')
    	// 	   ->once()
        //        ->andReturn('{}');

    	// $this->get('/charity-search/organization')
    	// 	 ->assertViewIs('charity-search::organization')
    	// 	 ->assertViewHas('response', ['data'=>[], 'message'=>'organization retrived', 'status'=>'success'])
        //      ->assertStatus(200);

        $this->get('/charity-search/organization?query=142007220')
    		 ->assertViewIs('charity-search::organization')
             ->assertStatus(200);
    }


    /** 
	 * @test
	 * 
	 */
    public function the_organization_route_can_be_accessed_as_post_request() {

    	$this->post('/charity-search/organization', ['_token' => csrf_token()])
    		 ->assertJson([])
             ->assertStatus(200);
    }
}