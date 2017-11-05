<?php
require(dirname(__FILE__) . '/../init.php');

$lazada = new Lazada\LazadaSellerCenter('https://api.sellercenter.lazada.sg', 'redacted', 'redacted');

try {
	$migratedImage = $lazada->Product()->MigrateImage('http://via.placeholder.com/350x150');
} catch (Exception $e) {
	var_dump($e->errors);
}

var_dump($migratedImage);