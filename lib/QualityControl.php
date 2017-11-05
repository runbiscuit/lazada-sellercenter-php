<?php

namespace Lazada\LazadaSellerCenter;

use Lazada\Http\HttpClient;
use Lazada\Http\HttpHelper;
use Lazada\Http\ResponseHelper;

class QualityControl extends HttpClient {
	private $baseURL;
	private $version;
	private $userID;
	private $apiKey;
	private $format;

	private $parameters;

	/**
	 * Sets the private variables and base parameter array.
	 * 
	 * @param $baseURL Base URL of API
	 * @param $version Version (must always be 1.0)
	 * @param $userID User ID
	 * @param $apiKey API Key
	 * @param $format Format of response (always JSON)
	 */
	public function __construct($baseURL, $version, $userID, $apiKey, $format) {
		$this->baseURL = $baseURL;
		$this->version = $version;
		$this->userID = $userID;
		$this->apiKey = $apiKey;
		$this->format = $format;

		$this->parameters = [
			'UserID' => $this->userID,
			'Version' => $this->version,
			'Format' => $this->format,
			'APIKey' => $this->apiKey
		];
	}

	/**
	 * Get the quality control status of items listing.
	 *
	 * @param $parameters Parameters accepted by API:
	 * - Offset integer
	 * - SkuSellerList string[]
	 * 
	 * @return stdClass[]
	 */
	public function GetQcStatus($parameters) {
		// set the action as required
		$this->parameters['Action'] = 'GetQcStatus';

		// make the http request
		$data = HttpClient::makeCall($this->baseURL, $this->parameters);

		// handle the response given
		return ResponseHelper::property($data, 'SuccessResponse->Body->Status');
	}
}