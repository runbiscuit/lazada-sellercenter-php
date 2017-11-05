<?php

namespace Lazada;

use Lazada\LazadaSellerCenter\Order;
use Lazada\LazadaSellerCenter\Product;
use Lazada\LazadaSellerCenter\ShippingProvider;
use Lazada\LazadaSellerCenter\QualityControl;

/**
 * Class LazadaSellerCenter
 * 
 * @package LazadaSellerCenter
 */
class LazadaSellerCenter {
	// @var string The base URL for Seller Center API Instance.
	public static $baseURL = 'https://api.sellercenter.lazada.sg';

	// @var string The version of Seller Center API.
	public static $version = '1.0';

	// @var string The userID to identify as during Seller Center API requests.
	public static $userID = '';

	// @var string The API key to be used for authenticating Seller Center API requests.
	public static $apiKey = '';

	// @var string The format of output from Seller Center API.
	// only json is supported by this library, so it shall be used.
	public static $format = 'json';

	/**
	 * @param string The base URL of the Seller Center API Instance.
	 * @param string The userID to identify as during Seller Center API requests.
	 * @param string The API key to be used for authenticating Seller Center API requests.
	 */
	public function __construct($baseURL = NULL, $userID = NULL, $apiKey = NULL) {
		if (!empty($baseURL) && !empty($userID) && !empty($apiKey)) {
			// set the variables
			$this::$baseURL = $baseURL;
			$this::$userID = $userID;
			$this::$apiKey = $apiKey;
		}

		else {
			throw new \Exception("baseURL, userID and apiKey must be provided!", 1);
		}
	}

	/**
	 * @return string The base URL of the Seller Center API Instance.
	 */
	public function getBaseURL(){
		return $this::$baseURL;
	}

	/**
	 * @return string The userID to identify as during Seller Center API requests.
	 */
	public function getUserID(){
		return $this::$userID;
	}

	/**
	 * @return string The API key to be used for authenticating Seller Center API requests.
	 */
	public function getAPIkey(){
		return $this::$apiKey;
	}

	/**
	 * Sets the base URL of the Seller Center API Instance.
	 * 
	 * @param string $baseURL
	 */
	public function setBaseURL($baseURL) {
		$this::$baseURL = $baseURL;
	}

	/**
	 * Sets the userID to identify as during Seller Center API requests.
	 * 
	 * @param string $userID
	 */
	public function setUserID($userID) {
		$this::$userID = $userID;
	}

	/**
	 * Sets the API key to be used for authenticating Seller Center API requests.
	 * 
	 * @param string $apiKey
	 */
	public function setAPIkey($apiKey) {
		$this::$apiKey = $apiKey;
	}

	/**
	 * Gets the orders class and related items.
	 * 
	 * @return Lazada\LazadaSellerCenter\Order
	 */
	public function Order() {
		return new Order(
			$this::$baseURL, $this::$version, $this::$userID, $this::$apiKey, $this::$format
		);
	}

	/**
	 * Gets the orders class and related items.
	 * 
	 * @return Lazada\LazadaSellerCenter\Order
	 */
	public function Product() {
		return new Product(
			$this::$baseURL, $this::$version, $this::$userID, $this::$apiKey, $this::$format
		);
	}

	/**
	 * Gets the orders object.
	 * 
	 * @return Lazada\LazadaSellerCenter\ShippingProvider
	 */
	public function ShippingProvider() {
		return new ShippingProvider(
			$this::$baseURL, $this::$version, $this::$userID, $this::$apiKey, $this::$format
		);
	}

	/**
	 * Gets the orders object.
	 * 
	 * @return Lazada\LazadaSellerCenter\QualityControl
	 */
	public function QualityControl() {
		return new QualityControl(
			$this::$baseURL, $this::$version, $this::$userID, $this::$apiKey, $this::$format
		);
	}
}