# lazada-sellercenter-php
PHP library for the Lazada Seller Center API, based off the [official documentation](https://lazada-sellercenter.readme.io/docs).

## Requirements
PHP 5.5 and later.

## Composer Installation
You can install the bindings via Composer. Run the following command:

```bash
composer require theroyalstudent/lazada-sellercenter-php
```

To use the bindings, use Composer's autoload:

```php
require_once('vendor/autoload.php');
```

## Getting Started
Simple usage (e.g: migrating an image) looks like this:

```php
$lazada = new Lazada\LazadaSellerCenter('https://api.sellercenter.lazada.sg', 'redacted', 'redacted');

try {
	$migratedImage = $lazada->Product()->MigrateImage('http://via.placeholder.com/350x150');
} catch (Exception $e) {
	var_dump($e->errors);
}

var_dump($migratedImage);
```

Advanced usage (e.g: retrieving orders) look like this:

```php
$lazada = new Lazada\LazadaSellerCenter('https://api.sellercenter.lazada.sg', 'redacted', 'redacted');

try {
	$orders = $lazada->Order()->GetOrders([
		'SortBy' => 'UpdatedBefore',
		'SortDirection' => 'asc'
	]);
} catch (Exception $e) {
	var_dump($e->errors);
}

var_dump($orders)
```

## Documentation
Please see [https://lazada-sellercenter.readme.io/docs](https://lazada-sellercenter.readme.io/docs) for up-to-date documentation.

## Credits
* [@theroyalstudent](https://github.com/theroyalstudent) for the initial work.
* [Lazada Seller Center](https://lazada-sellercenter.readme.io/docs) for the API.

#### Libraries Used:
* [Guzzle 6](http://docs.guzzlephp.org/en/stable/quickstart.html)

## Licenses

Copyright (C) 2017 [Edwin A.](https://theroyalstudent.com) <edwin@theroyalstudent.com>

This work is licensed under the Creative Commons Attribution-ShareAlike 3.0

Unported License: http://creativecommons.org/licenses/by-sa/3.0/