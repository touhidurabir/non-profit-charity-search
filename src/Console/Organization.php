<?php

namespace Touhidurabir\NonProfitCharitySearch\Console;

use Exception;
use Illuminate\Console\Command;
use Touhidurabir\NonProfitCharitySearch\Facades\NonProfitCharitySearch;

class Organization extends Command {

	/**
     * The name and signature of the console command.
     *
     * @var string
     */
	protected $signature = 'charity-search:organization
							{query        : search query}
							{--dump=false : dump the api response to command console}';


	/**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Output organization details.';


    /**
     * The table headers for the command.
     *
     * @var array
     */
    protected $headers = ['Title', 'Details'];


    /**
     * Display resppnses
     *
     * @param  string $jsonResponse
     * @param  object $charities
     *
     * @return void 
     */
    protected function displayResult($jsonResponse, $organization): void {

    	$result = json_decode($jsonResponse, true);

    	$this->info("API URL : {$organization->getGenratedApiUrl()}");
    	
    	$this->table(
    		$this->headers, 
    		array_map(function($key, $value){
    			return [$key, $value];
    		}, array_keys($result['organization']), $result['organization'])
    	);

        if ( filter_var($this->option('dump'), FILTER_VALIDATE_BOOLEAN) ) { 
            $this->info("Dumped API Response : ");
            $this->info($jsonResponse);
        }
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

    	try {

    		$organization = NonProfitCharitySearch::search($this->argument('query'))
    											  ->organization();

    		$this->displayResult($organization->getResult(), $organization);

    	} catch (Exception $exception) {

    		$this->error("Throws Exception with code : {$exception->getCode()}");
    		$this->error("Exception Message : {$exception->getMessage()}");
    		
    	}
    }

}