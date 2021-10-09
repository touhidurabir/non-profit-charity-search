<?php

namespace Touhidurabir\NonProfitCharitySearch\Contracts;

interface CharityContract {

	/**
     * Generate API URL
     *
     * @return string
     */
	public function getGenratedApiUrl(): string;


	/**
     * Get API response
     */
	public function getResult();
}