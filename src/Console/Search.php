<?php

namespace Touhidurabir\NonProfitCharitySearch\Console;

use Exception;
use Illuminate\Console\Command;
use Touhidurabir\NonProfitCharitySearch\Facades\NonProfitCharitySearch;

class Search extends Command {

	/**
     * The name and signature of the console command.
     *
     * @var string
     */
	protected $signature = 'charity-search:search
							{query        : search query}
							{--page=      : search page number}
							{--state=     : filter api request by state code}
							{--ntee=      : filter api request by NTEE code}
							{--c_code=    : filter api request by C COde code}
							{--dump=false : dump the api response to command console}';


	/**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Output charity search result.';


    /**
     * The table headers for the command.
     *
     * @var array
     */
    protected $headers = ['Ein', 'Name', 'City', 'State', 'Ntee', 'Subseccd', 'Score'];


    /**
     * Permittable columns to table representation of api response organization details
     *
     * @var array
     */
    protected $permittables = ['ein', 'name', 'city', 'state', 'ntee_code', 'subseccd', 'score'];


    /**
     * Permittable query params mapper
     *
     * @var array
     */
    protected $queryParamPermittables = [
        'state[id]'   =>  'state', 
        'ntee[id]'    =>  'ntee', 
        'c_code[id]'  =>  'c_code', 
        'page'        =>  'page'
    ];


    /**
     * Sanitize target data with provided $permittables structure
     *
     * @param  array $target
     * @param  array $permittables
     *
     * @return array 
     */
    protected function sanitizeToPermittables(array $target, array $permittables): array {

    	return 
    		array_intersect_key(
				$target, array_flip($permittables)
			);
    }


    /**
     * Genrate the proper param structure that is usable for api
     *
     * @param  array $opts
     * @return array 
     */
    protected function buildParamStructure($opts): array {

    	$opts = $this->sanitizeToPermittables($opts, array_values($this->queryParamPermittables));

    	foreach ($opts as $key => $value) {
		
			if ( in_array($key, $this->queryParamPermittables) ) {
				
				$opts[array_flip($this->queryParamPermittables)[$key]] = $value;
			}
		}

    	return $this->sanitizeToPermittables($opts, array_keys($this->queryParamPermittables));
    }


    /**
     * Genrate the table presentable data
     *
     * @param  array $results
     * @return array 
     */
    protected function generateTableData(array $results = []): array {

    	$data = [];

    	foreach ($results as $key => $value) {

    		$data[] = array_values($this->sanitizeToPermittables($value, $this->permittables));
    	}

    	return $data;
    }


    /**
     * Display resppnses
     *
     * @param  string $jsonResponse
     * @param  object $charities
     *
     * @return void 
     */
    protected function displayResult($jsonResponse, $charities): void {

    	$result = json_decode($jsonResponse, true);

    	$this->info("API URL             : {$charities->getGenratedApiUrl()}");
    	$this->info("Total Organizations : {$result['total_results']}");
    	$this->info("Current Page        : {$result['cur_page']}");

        $this->table($this->headers, $this->generateTableData($result['organizations']));

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

    		$charities = NonProfitCharitySearch::search(
							$this->argument('query'), 
							$this->buildParamStructure($this->options())
						)->charities();

    		$this->displayResult($charities->getResult(), $charities);

    	} catch (Exception $exception) {

    		$this->error("Throws Exception with code : {$exception->getCode()}");
    		$this->error("Exception Message : {$exception->getMessage()}");
    		
    	}
    }

}