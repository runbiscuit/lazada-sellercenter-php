<?php

namespace Lazada\Http;

use GuzzleHttp\Client;
use DateTime;

class HttpHelper {
	/**
	 * Prepares parameters for making requests.
	 * 
	 * @param $parameters array[]
	 * @return array[]
	*/
	public static function handle($parameters) {
		foreach ($parameters as $key => $value) {
			if (($key == 'CreatedBefore' || $key == 'CreatedAfter' || $key == 'UpdatedBefore' || $key == 'UpdatedAfter') && $value instanceOf DateTime) {
				$value = $value->format(DateTime::ISO8601);
			}
		}

		return $parameters;
	}
}