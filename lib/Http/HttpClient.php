<?php

namespace Lazada\Http;

use SimpleXMLElement;
use DateTime;

use Lazada\Http\ResponseHelper;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\BadResponseException;

class HttpClient {
	/**
	 * Make the HTTP request as requested.
	 * 
	 * @param $baseURL string
	 * @param $parameters array[]
	 * 
	 * @return mixed
	 */
	public static function makeCall($baseURL, $parameters) {
		// preparing the signature
		$parameters['Timestamp'] = (new DateTime())->format(DateTime::ISO8601);
		
		// remove unneeded parameters
		$apiKey = $parameters['APIKey'];
		unset($parameters['APIKey']);

		$encoded = array();
		ksort($parameters);

		foreach ($parameters as $name => $value) {
			$encoded[] = rawurlencode($name) . '=' . rawurlencode($value);
		}

		$concatenated = implode('&', $encoded);
		$parameters['Signature'] = rawurlencode(hash_hmac('sha256', $concatenated, $apiKey, false));

		// make the request, once ready
		$client = new Client();
		$request = $client->request('GET', $baseURL, [
			'query' => $parameters
		]);

		// get body of request
		if (strpos($response->getHeader('Content-Length'), 'json') != -1) {
			$response = json_decode($request->getBody());
		}

		else {
			$response = new SimpleXMLElement($request->getBody());
		}

		if (!$response) {
			throw new \Exception("HTTP request failed.");
		}

		else if (ResponseHelper::property($response, 'ErrorResponse->Head->ErrorMessage') !== null) {
			throw new \Exception($response->ErrorResponse->Head->ErrorMessage);
		}

		else {
			return $response;
		}
	}

	/**
	 * Make the HTTP POST request as requested.
	 * The HTTP POST API is only available in XML.
	 * 
	 * @param $baseURL string
	 * @param $parameters array[]
	 * 
	 * @return mixed
	 */
	public static function makePostCall($baseURL, $parameters, $rawData) {
		// preparing the signature
		$parameters['Timestamp'] = (new DateTime())->format(DateTime::ISO8601);

		// forced to use XML for such requests
		$parameters['Format'] = 'XML';
		
		// remove unneeded parameters
		$apiKey = $parameters['APIKey'];
		unset($parameters['APIKey']);

		$encoded = array();
		ksort($parameters);

		foreach ($parameters as $name => $value) {
			$encoded[] = rawurlencode($name) . '=' . rawurlencode($value);
		}

		$queryString = implode('&', $encoded);
		$queryString = $queryString . '&Signature=' . rawurlencode(hash_hmac('sha256', $queryString, $apiKey, false));

		// make the request, once ready
		$client = new Client();
		
		try {
			$request = $client->request('POST', $baseURL . '?' . $queryString, [
				'headers' => [
					'Content-Type' => 'text/xml; charset=UTF8'
				],
				'body' => $rawData
			], $rawData);
		} catch (RequestException $e) {
		    return Psr7\str($e->getResponse());
		} catch (ConnectException $e) {
		    return Psr7\str($e->getResponse());
		} catch (ClientException $e) {
		    return Psr7\str($e->getResponse());
		} catch (BadResponseException $e) {
		    return Psr7\str($e->getResponse());
		}

		// get body of request
		$response = new SimpleXMLElement($request->getBody());

		if (ResponseHelper::property($response, 'ErrorResponse->Head->ErrorMessage') != null) {
			throw new \Exception($response->ErrorResponse->Head->ErrorMessage);
		}

		else if (ResponseHelper::property($response, 'Head->ErrorMessage') != null && ResponseHelper::property($response, 'Body->Errors') != null) {
			$exception = new \Exception($response->Head->ErrorMessage);
			$exception->errors = $response->Body->Errors;

			throw $exception;
		}

		else if (ResponseHelper::property($response, 'Head->ErrorMessage') != null) {
			throw new \Exception($response->Head->ErrorMessage);
		}

		else {
			return $response;
		}
	}
}