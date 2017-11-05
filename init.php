<?php

// Composer Libraries
require(dirname(__FILE__) . '/vendor/autoload.php');

// LazadaSellerCenter class
require(dirname(__FILE__) . '/lib/LazadaSellerCenter.php');

// HttpClient & HttpHelper
require(dirname(__FILE__) . '/lib/Http/HttpClient.php');
require(dirname(__FILE__) . '/lib/Http/HttpHelper.php');
require(dirname(__FILE__) . '/lib/Http/ResponseHelper.php');

// Order classes
require(dirname(__FILE__) . '/lib/Order.php');
require(dirname(__FILE__) . '/lib/Product.php');
require(dirname(__FILE__) . '/lib/ShippingProvider.php');
require(dirname(__FILE__) . '/lib/QualityControl.php');