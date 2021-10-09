<?php

use Touhidurabir\NonProfitCharitySearch\CharitySearch;

require '../vendor/autoload.php';

$charitySearch = new CharitySearch('541866612');

$result = $charitySearch->organization()->getResult();

echo $result;
