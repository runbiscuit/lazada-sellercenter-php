<?php

namespace Lazada\LazadaSellerCenter;

use Lazada\Http\HttpClient;
use Lazada\Http\HttpHelper;
use Lazada\Http\ResponseHelper;

class Order extends HttpClient {
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
	 * Get the customer details for a range of orders.
	 * GetOrders is substantially different from GetOrder, which retrieves the items of an order.
	 *
	 * @param $parameters Parameters accepted by API:
	 * - CreatedBefore
	 * - CreatedAfter
	 * - UpdatedBefore
	 * - UpdatedAfter
	 * - Limit
	 * - Offset
	 * - Status
	 * - SortBy
	 * - SortDirection - asc, desc
	 * 
	 * @return stdClass[]
	 */
	public function GetOrders($parameters = []) {
		// set the action as required
		$this->parameters['Action'] = 'GetOrders';

		// merge the prepared parameters with base parameters
		$parameters = HttpHelper::handle($parameters);
		$this->parameters = array_merge($this->parameters, $parameters);

		// make the http request
		$data = HttpClient::makeCall($this->baseURL, $this->parameters);

		// handle the response given
		return ResponseHelper::property($data, 'SuccessResponse->Body->Orders');
	}

	/**
	 * Get the list of items for a single order.
	 *
	 * @param $parameters Parameters accepted by API:
	 * - OrderId
	 * 
	 * @return stdClass
	 */
	public function GetOrder($parameters = []) {
		// set the action as required
		$this->parameters['Action'] = 'GetOrder';

		// merge the prepared parameters with base parameters
		$parameters = HttpHelper::handle($parameters);
		$this->parameters = array_merge($this->parameters, $parameters);

		// make the http request
		$data = HttpClient::makeCall($this->baseURL, $this->parameters);

		// handle the response given
		$data = ResponseHelper::property($data, 'SuccessResponse->Body->Orders');
		return (isset($data[0])) ? $data[0] : null;
	}

	/**
	 * Returns the item information in an order.
	 *
	 * @param $parameters Parameters accepted by API:
	 * - OrderId
	 * 
	 * @return stdClass[]
	 */
	public function GetOrderItems($parameters = []) {
		// set the action as required
		$this->parameters['Action'] = 'GetOrderItems';

		// merge the prepared parameters with base parameters
		$parameters = HttpHelper::handle($parameters);
		$this->parameters = array_merge($this->parameters, $parameters);

		// make the http request
		$data = HttpClient::makeCall($this->baseURL, $this->parameters);

		// handle the response given
		$data = ResponseHelper::property($data, 'SuccessResponse->Body->OrderItems');
		return (isset($data[0])) ? $data : null;
	}

	/**
	 * Cancel a single item.
	 * 
	 * @param $parameters Parameters accepted by API:
	 * - OrderItemId
	 * - GetFailureReasons
	 * - ReasonDetail
	 * 
	 * @return boolean
	 */
	public function SetStatusToCanceled($parameters = []) {
		// set the action as required
		$this->parameters['Action'] = 'SetStatusToCanceled';

		// merge the prepared parameters with base parameters
		$parameters = HttpHelper::handle($parameters);
		$this->parameters = array_merge($this->parameters, $parameters);

		// make the http request
		$data = HttpClient::makeCall($this->baseURL, $this->parameters);

		// handle the response given
		return (ResponseHelper::property($data, 'SuccessResponse->Head->Timestamp')) ? true : false;
	}

	/**
	 * Mark an order item as being packed.
	 * 
	 * @param $parameters Parameters accepted by API:
	 * - OrderItemIds
	 * - DeliveryType
	 * - ShippingProvider
	 * 
	 * @return boolean
	 */
	public function SetStatusToPackedByMarketplace($parameters = []) {
		// set the action as required
		$this->parameters['Action'] = 'SetStatusToPackedByMarketplace';

		// merge the prepared parameters with base parameters
		$parameters = HttpHelper::handle($parameters);
		$this->parameters = array_merge($this->parameters, $parameters);

		// make the http request
		$data = HttpClient::makeCall($this->baseURL, $this->parameters);

		// handle the response given
		$data = ResponseHelper::property($data, 'SuccessResponse->Body->OrderItems');
		return (isset($data[0])) ? $data : null;
	}

	/**
	 * Mark an order item as being ready to ship.
	 * 
	 * @param $parameters Parameters accepted by API:
	 * - OrderItemIds
	 * - DeliveryType
	 * - ShippingProvider
	 * - SerialNumber
	 * 
	 * @return boolean
	 */
	public function SetStatusToReadyToShip($parameters = []) {
		// set the action as required
		$this->parameters['Action'] = 'SetStatusToReadyToShip';

		// merge the prepared parameters with base parameters
		$parameters = HttpHelper::handle($parameters);
		$this->parameters = array_merge($this->parameters, $parameters);

		// make the http request
		$data = HttpClient::makeCall($this->baseURL, $this->parameters);

		// handle the response given
		$data = ResponseHelper::property($data, 'SuccessResponse->Body->OrderItems');
		return (isset($data[0])) ? $data : null;
	}

	/**
	 * Retrieve order-related documents, including invoices, shipping labels, and shipping parcels.
	 * 
	 * @param $parameters Parameters accepted by API:
	 * - OrderItemIds
	 * - DocumentType
	 * 
	 * @return boolean
	 */
	public function GetDocument($parameters = []) {
		// set the action as required
		$this->parameters['Action'] = 'GetDocument';

		// merge the prepared parameters with base parameters
		$parameters = HttpHelper::handle($parameters);
		$this->parameters = array_merge($this->parameters, $parameters);

		// make the http request
		$data = HttpClient::makeCall($this->baseURL, $this->parameters);

		// handle the response given
		$data = ResponseHelper::property($data, 'SuccessResponse->Body->Document');
		return (isset($data[0])) ? $data : null;
	}

	/**
	 * Retrieve order-related documents, including invoices, shipping labels, and shipping parcels.
	 * 
	 * @param $parameters Parameters accepted by API:
	 * - OrderItemIds
	 * - DocumentType
	 * 
	 * @return boolean
	 */
	public function GetFailureReasons($parameters = []) {
		// set the action as required
		$this->parameters['Action'] = 'GetFailureReasons';

		// merge the prepared parameters with base parameters
		$parameters = HttpHelper::handle($parameters);
		$this->parameters = array_merge($this->parameters, $parameters);

		// make the http request
		$data = HttpClient::makeCall($this->baseURL, $this->parameters);

		// handle the response given
		$data = ResponseHelper::property($data, 'SuccessResponse->Body->Document');
		return (isset($data[0])) ? $data : null;
	}

	/**
	 * Set the invoice access key.
	 * 
	 * @param $parameters Parameters accepted by API:
	 * - OrderItemId
	 * - InvoiceNumber
	 * 
	 * @return boolean
	 */
	public function SetInvoiceNumber($parameters = []) {
		// set the action as required
		$this->parameters['Action'] = 'SetInvoiceNumber';

		// merge the prepared parameters with base parameters
		$parameters = HttpHelper::handle($parameters);
		$this->parameters = array_merge($this->parameters, $parameters);

		// make the http request
		$data = HttpClient::makeCall($this->baseURL, $this->parameters);

		// handle the response given
		$data = ResponseHelper::property($data, 'SuccessResponse->Body');
		return (isset($data[0])) ? $data : null;
	}
}