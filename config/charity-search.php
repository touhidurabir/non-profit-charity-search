<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Route Configuration
    |--------------------------------------------------------------------------
    |
    | Define the route configuration
    | enable --> route should be enable to not
    | prefix --> common route path prefix , example /charity-search/search
    | controller --> controller with full namespace
    | path --> array contains the route path for GET, POST, .. ect request
    |     get --> 
    |          search --> 
    |              uri --> route path that will be concatenated with the prefix
    |              method --> controller method to handle that route request
    |     post --> 
    |          search --> 
    |              uri --> route path that will be concatenated with the prefix
    |              method --> controller method to handle that route request
    */

    'route' => [
    	'enable' => true,
    	'prefix' => '/charity-search',
    	'controller' => 'Touhidurabir\NonProfitCharitySearch\Http\Controllers\CharitySearchController',
    	'paths' => [
    		'get' => [
    			'search' => [
    				'uri' => '/search',
    				'method' => 'search'
    			],
    			'organization' => [
    				'uri' => '/organization',
    				'method' => 'organization'
    			]
    		],
    		'post' => [
    			'search' => [
    				'uri' => '/search',
    				'method' => 'search'
    			],
    			'organization' => [
    				'uri' => '/organization',
    				'method' => 'organization'
    			]
    		]
    	]
    ],


    /*
    |--------------------------------------------------------------------------
    | Route Middleware Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can specify the route middleware that should be applied the
    | charity-search routes. The default middleware is set to web but better 
    | to add the auth also. If you have any additional authorization to
    | perform, this would be the place to specify it.
    |
    */

    'middlewares' => ['web'],

];