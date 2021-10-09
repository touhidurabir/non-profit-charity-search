<?php

namespace Touhidurabir\NonProfitCharitySearch\Facades;

use Illuminate\Support\Facades\Facade;

class NonProfitCharitySearch extends Facade {

	/**
     * Get the registered name of the component.
     *
     * @return string
     */
	protected static function getFacadeAccessor() {

		return 'non-profit-charity-search';
	}
}