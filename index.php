<?php

require_once 'vendor/autoload.php';

$re = new App\ExchangedAmount("USD", "UAH", 100);
echo $re->toDecimal();
