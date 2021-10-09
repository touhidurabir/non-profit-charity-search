<?php

namespace Touhidurabir\NonProfitCharitySearch\Tests\LaravelTest;

use RuntimeException;
use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\Artisan;
use Touhidurabir\NonProfitCharitySearch\Facades\NonProfitCharitySearch;
use Touhidurabir\NonProfitCharitySearch\Tests\LaravelTest\Concerns\LaravelTestBootstrapping;
use Touhidurabir\NonProfitCharitySearch\Console\Search;
use Touhidurabir\NonProfitCharitySearch\Console\Organization;

class CommandTest extends TestCase {

	/** 
     * Load laravel test specific bootstrapping methods
     */
    use LaravelTestBootstrapping;

    
    /** 
	 * @test
	 * 
	 */
    public function search_command_will_run() {

    	// $this->withoutMockingConsoleOutput();

    	$command = $this->artisan('charity-search:search', ['query' => 'no-result']);

        $command->assertExitCode(0);

        $command = $this->artisan('charity-search:search', ['query' => 'buff', '--dump' => true]);

        $command->assertExitCode(0);
    }


    /** 
	 * @test
	 * 
	 */
    public function search_command_will_throw_exception_if_query_augument_not_given() {

    	$command = $this->artisan('charity-search:search');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "query").');
    }


    /** 
	 * @test
	 * 
	 */
    public function organization_command_will_run() {

    	$command = $this->artisan('charity-search:organization', ['query' => '123456789', '--dump' => true]);

        $command->assertExitCode(0);

        $command = $this->artisan('charity-search:organization', ['query' => '142007220', '--dump' => true]);

        $command->assertExitCode(0);
    }


    /** 
	 * @test
	 * 
	 */
    public function organization_command_will_throw_exception_if_query_augument_not_given() {

    	$command = $this->artisan('charity-search:organization');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "query").');
    }
    
}