<?php

namespace Touhidurabir\NonProfitCharitySearch\Http\Controllers;

use Exception;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Touhidurabir\NonProfitCharitySearch\Facades\NonProfitCharitySearch;

class CharitySearchController extends BaseController {

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        $this->middleware(config('charity-search.middlewares'));

    }


    /**
     * Search Charity
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {

    	try {

    		$search = NonProfitCharitySearch::search(
				    		$request->get('query'),
				    		$request->get('params') ?? []
				    	)->charities();	

    		$result = $search->getResult();

    		return $this->sendResponse('charities', $result, $request, 'search completed');

    	} catch (Exception $exception) {

            return $this->sendResponse('charities', '{}', $request, $exception->getMessage(), 'danger');
    	}
    }


    /**
     * Retrieve Organization Details
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function organization(Request $request) {
    	
    	try {

    		$organization = NonProfitCharitySearch::search($request->get('query'))
    											  ->organization();

    		$result = $organization->getResult();

    		return $this->sendResponse('organization', $result, $request, 'organization retrived');

    	} catch (Exception $exception) {
            
    		return $this->sendResponse('organization', '{}', $request, $exception->getMessage(), 'danger');
    	}
    }


    /**
     * Build and return the proper resposne
     *
     * @param  string   $view
     * @param  mixed    $data
     * @param  Request  $request
     * @param  string   $message
     * @param  string   $status
     *
     * @return mixed
     */
    protected function sendResponse(string $view, $data, Request $request, string $message = '', string $status = 'success') {

        $response = [
            'data'    => json_decode($data, true),
            'message' => $message,
            'status'  => $status
        ];

    	return 
    		$request->method() == 'GET'
				? view("charity-search::$view", ['response' => $response])
				: response()->json($response);
    }
}