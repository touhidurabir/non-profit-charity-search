<?php

use Touhidurabir\NonProfitCharitySearch\CharitySearch;

require '../vendor/autoload.php';

$charitySearch = new CharitySearch('buff');

$result = $charitySearch->charities()->getResult();

echo $result;