<?php

namespace Lazada\LazadaSellerCenter;

use DOMDocument;
use SimpleXMLElement;

use Lazada\Http\HttpClient;
use Lazada\Http\HttpHelper;
use Lazada\Http\ResponseHelper;

class Product extends HttpClient {
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
	 * Get all or a range of products.
	 *
	 * @param $parameters Parameters accepted by API:
	 * - CreatedAfter datetime
	 * - CreatedBefore datetime
	 * - UpdatedAfter datetime
	 * - UpdatedBefore datetime
	 * - Search string
	 * - Filter string
	 * - Limit integer
	 * - Options integer
	 * - Offset integer
	 * - SkuSellerList string[]
	 * 
	 * @return stdClass[]
	 */
	public function GetProducts($parameters) {
		// set the action as required
		$this->parameters['Action'] = 'GetProducts';

		// merge the prepared parameters with base parameters
		$parameters = HttpHelper::handle($parameters);
		$this->parameters = array_merge($this->parameters, $parameters);

		// make the http request
		$data = HttpClient::makeCall($this->baseURL, $this->parameters);

		// handle the response given
		return ResponseHelper::property($data, 'SuccessResponse->Body->Products');
	}

	/**
	 * Search SPU information by category and some keywords. The maximum number of SPUs is 100 in the response body.
	 *
	 * @param $parameters Parameters accepted by API:
	 * - CategoryId string
	 * - Search string
	 * - Offset integer
	 * - Limit integer
	 * 
	 * @return stdClass[]
	 */
	public function SearchSPUs($parameters) {
		// set the action as required
		$this->parameters['Action'] = 'SearchSPUs';

		// merge the prepared parameters with base parameters
		$parameters = HttpHelper::handle($parameters);
		$this->parameters = array_merge($this->parameters, $parameters);

		// make the http request
		$data = HttpClient::makeCall($this->baseURL, $this->parameters);

		// handle the response given
		return ResponseHelper::property($data, 'SuccessResponse->Body->SPUs');
	}

	/**
	 * Upload a single image file and accept binary stream with file content.
	 * Allowed image formats are JPG and PNG. The maximum size of an image file is 3MB.
	 *
	 * @param $parameters Parameters accepted by API:
	 * - Image file
	 * 
	 * @return stdClass[]
	 */
	public function UploadImage($parameters) {
		// set the action as required
		$this->parameters['Action'] = 'UploadImage';

		// merge the prepared parameters with base parameters
		$parameters = HttpHelper::handle($parameters);
		$this->parameters = array_merge($this->parameters, $parameters);

		// make the http request
		$data = HttpClient::makePostCall($this->baseURL, $this->parameters);

		// handle the response given
		return ResponseHelper::property($data, 'SuccessResponse->Body->Image');
	}

	/**
	 * Migrate images from an external site to Lazada site. Allowed image formats are JPG and PNG.
	 * The maximum size of an image file is 3MB.
	 *
	 * @param $url URL of the image
	 * 
	 * @return stdClass[]
	 */
	public function MigrateImage($url) {
		// set the action as required
		$this->parameters['Action'] = 'MigrateImage';

		// prepare the required XML request body
		// make the http request
		$XMLrequestBody = new DOMDocument;
		$XMLrequestBody->preserveWhiteSpace = FALSE;
		$XMLrequestBody->loadXML('<Request><Image><Url>' . $url . '</Url></Image></Request>');
		$XMLrequestBody->formatOutput = TRUE;
		$XMLrequestBody = $XMLrequestBody->saveXML();

		try {
			$data = HttpClient::makePostCall($this->baseURL, $this->parameters, $XMLrequestBody);
		} catch (Exception $e) {
			throw $e;
		}

		// handle the response given
		return ResponseHelper::property($data, 'Body->Image');
	}

	/**
	 * Create a new product. One item may contain at lest one SKU which has 8 images.
	 * This API does not support multiple products in one request.
	 *
	 * @param $xml XML of the new product
	 * 
	 * @return stdClass[]
	 */
	public function CreateProduct($xml) {
		// set the action as required
		$this->parameters['Action'] = 'CreateProduct';

		// prepare the required XML request body
		// make the http request
		$XMLrequestBody = new DOMDocument;
		$XMLrequestBody->preserveWhiteSpace = FALSE;
		$XMLrequestBody->loadXML($xml);
		$XMLrequestBody->formatOutput = TRUE;
		$XMLrequestBody = $XMLrequestBody->saveXML();

		try {
			$data = HttpClient::makePostCall($this->baseURL, $this->parameters, $XMLrequestBody);
		} catch (Exception $e) {
			throw $e;
		}

		// handle the response given
		return ResponseHelper::property($data, 'SuccessResponse->Head');
	}

	/**
	 * Update attributes or SKUs of an existing product.
	 * Note that update to multiple products in one request is not supported.
	 *
	 * @param $xml XML of the new product
	 * 
	 * @return stdClass[]
	 */
	public function UpdateProduct($xml) {
		// set the action as required
		$this->parameters['Action'] = 'UpdateProduct';

		// prepare the required XML request body
		// make the http request
		$XMLrequestBody = new DOMDocument;
		$XMLrequestBody->preserveWhiteSpace = FALSE;
		$XMLrequestBody->loadXML($xml);
		$XMLrequestBody->formatOutput = TRUE;
		$XMLrequestBody = $XMLrequestBody->saveXML();

		try {
			$data = HttpClient::makePostCall($this->baseURL, $this->parameters, $XMLrequestBody);
		} catch (Exception $e) {
			throw $e;
		}

		// handle the response given
		return ResponseHelper::property($data, 'SuccessResponse->Head');
	}

	/**
	 * Set the images for an existing product by associating one or more image URLs with it.
	 * System supports a maximum of 100 SellerSkus in one request. The first image passed in becomes the default image if the product.
	 * There is a hard limit of at most 8 images per SKU.
	 * You can also use “UpdateProduct” API to set images.
	 *
	 * @param $xml XML of the new product SKU and image links
	 * 
	 * @return stdClass[]
	 */
	public function SetImages($xml) {
		// set the action as required
		$this->parameters['Action'] = 'SetImages';

		// prepare the required XML request body
		// make the http request
		$XMLrequestBody = new DOMDocument;
		$XMLrequestBody->preserveWhiteSpace = FALSE;
		$XMLrequestBody->loadXML($xml);
		$XMLrequestBody->formatOutput = TRUE;
		$XMLrequestBody = $XMLrequestBody->saveXML();

		try {
			$data = HttpClient::makePostCall($this->baseURL, $this->parameters, $XMLrequestBody);
		} catch (Exception $e) {
			throw $e;
		}

		// handle the response given
		return ResponseHelper::property($data, 'SuccessResponse->Head');
	}

	/**
	 * Update the price and quantity of one or more existing products.
	 * The maximum number of products that can be updated is 50, but 20 is recommended.
	 *
	 * @param $xml XML of the new product SKU and prices
	 * 
	 * @return stdClass[]
	 */
	public function UpdatePriceQuantity($xml) {
		// set the action as required
		$this->parameters['Action'] = 'UpdatePriceQuantity';

		// prepare the required XML request body
		// make the http request
		$XMLrequestBody = new DOMDocument;
		$XMLrequestBody->preserveWhiteSpace = FALSE;
		$XMLrequestBody->loadXML($xml);
		$XMLrequestBody->formatOutput = TRUE;
		$XMLrequestBody = $XMLrequestBody->saveXML();

		try {
			$data = HttpClient::makePostCall($this->baseURL, $this->parameters, $XMLrequestBody);
		} catch (Exception $e) {
			throw $e;
		}

		// handle the response given
		return ResponseHelper::property($data, 'SuccessResponse->Head');
	}

	/**
	 * Remove an existing product.
	 * You can remove some SKUs in one product, or remove all SKUs in one product.
	 * System supports a maximum number of 100 SellerSkus in one request.
	 *
	 * @param $xml XML of the product SellerSKUs
	 * 
	 * @return stdClass[]
	 */
	public function RemoveProduct($xml) {
		// set the action as required
		$this->parameters['Action'] = 'RemoveProduct';

		// prepare the required XML request body
		// make the http request
		$XMLrequestBody = new DOMDocument;
		$XMLrequestBody->preserveWhiteSpace = FALSE;
		$XMLrequestBody->loadXML($xml);
		$XMLrequestBody->formatOutput = TRUE;
		$XMLrequestBody = $XMLrequestBody->saveXML();

		try {
			$data = HttpClient::makePostCall($this->baseURL, $this->parameters, $XMLrequestBody);
		} catch (Exception $e) {
			throw $e;
		}

		// handle the response given
		return ResponseHelper::property($data, 'SuccessResponse->Head');
	}

	/**
	 * Get all product brands in the system.
	 *
	 * @param $parameters Parameters accepted by API:
	 * - Offset integer
	 * - Limit integer
	 * 
	 * @return stdClass[]
	 */
	public function GetBrands($parameters) {
		// set the action as required
		$this->parameters['Action'] = 'GetBrands';

		// merge the prepared parameters with base parameters
		$parameters = HttpHelper::handle($parameters);
		$this->parameters = array_merge($this->parameters, $parameters);

		$data = HttpClient::makeCall($this->baseURL, $this->parameters);

		// handle the response given
		return ResponseHelper::property($data, 'SuccessResponse->Body->Brands');
	}

	/**
	 * Get the list of all product categories.
	 *
	 * @return stdClass[]
	 */
	public function GetCategoryTree() {
		// set the action as required
		$this->parameters['Action'] = 'GetCategoryTree';

		// merge the prepared parameters with base parameters
		$parameters = HttpHelper::handle($parameters);

		$data = HttpClient::makeCall($this->baseURL, $this->parameters);

		// handle the response given
		return ResponseHelper::property($data, 'SuccessResponse->Body->Brands');
	}

	/**
	 * Returns a list of attributes with options for a given category.
	 * It will also display attributes for TaxClass, with their possible values listed as options.
	 *
	 * @param $parameters Parameters accepted by API:
	 * - PrimaryCategory integer
	 * 
	 * @return stdClass[]
	 */
	public function GetCategoryAttributes() {
		// set the action as required
		$this->parameters['Action'] = 'GetCategoryAttributes';

		// merge the prepared parameters with base parameters
		$parameters = HttpHelper::handle($parameters);

		$data = HttpClient::makeCall($this->baseURL, $this->parameters);

		// handle the response given
		return json_decode(ResponseHelper::property($data, 'SuccessResponse->Body'));
	}
}