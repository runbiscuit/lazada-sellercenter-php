<?php

namespace Lazada\Http;

class ResponseHelper {
	public static function property($object, $properties) {
		$properties = explode('->', $properties);

		foreach ($properties as $property) {
			if (property_exists($object, $property)) {
				$object = $object->$property;
			}

			else {
				return NULL;
			}
		}

		return $object;
	}
}