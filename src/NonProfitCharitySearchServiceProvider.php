<?php

namespace Touhidurabir\NonProfitCharitySearch;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Touhidurabir\NonProfitCharitySearch\CharitySearch;
use Touhidurabir\NonProfitCharitySearch\Console\Search;
use Touhidurabir\NonProfitCharitySearch\Console\Organization;

class NonProfitCharitySearchServiceProvider extends ServiceProvider {

	/**
     * Bootstrap any application services.
     *
     * @return void
     */
	public function boot() {

		if ( $this->app->runningInConsole() ) {
			$this->commands([
				Search::class,
				Organization::class
			]);
		}

		$this->loadViewsFrom(__DIR__.'/../resources/views', 'charity-search');

		$this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/charity-search'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../config/charity-search.php' => base_path('config/charity-search.php'),
        ], 'config');

		$this->registerRoutes(); // Register Routes
	}


	/**
     * Register any application services.
     *
     * @return void
     */
	public function register() {

		$this->app->bind('non-profit-charity-search', function() {
			return new CharitySearch();
		});

		$this->mergeConfigFrom(__DIR__.'/../config/charity-search.php', 'charity-search');
	}


	/**
     * Register routes set in the config file
     *
     * @return void
     */
	protected function registerRoutes(): void {

		$route = config('charity-search.route');

		/**
	     * If routing is disable in config file, 
	     * Will not register any routes
	     */
		if ( isset($route['enable']) && filter_var($route['enable'], FILTER_VALIDATE_BOOLEAN) ) {

			$prefix     = $route['prefix'] ?? '';
			$controller = $route['controller'] ?? null;

			// if no controller set in config file, return
			if ( ! $controller ) { return; }

			if ( isset($route['paths']) && is_array($route['paths']) ) {
				
				foreach ($route['paths'] as $httpMethod => $path) {
					
					foreach ($path as $pathDetails) {
						
						Route::{$httpMethod}(
							"{$prefix}{$pathDetails['uri']}",
							"{$controller}@{$pathDetails['method']}"
						);
					}	
				}
			}

		}
	}

}