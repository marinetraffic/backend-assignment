<?php

namespace App\Utils;

use DB;
use App\Models\ShipPosition;

class ShipLocationRequestReader
{
	protected $requestInput;

	function __construct(array $requestInput)
	{
		$this->requestInput = $requestInput;
	}

	public function getResult()
	{
		$coll = ShipPosition::whereNotNull('mmsi');

		foreach($this->requestInput as $requestedField => $requestedValue) {

			$requestedClass = 'App\Utils\\' . $requestedField;

			if (class_exists($requestedClass)) {
				
				$newField = new $requestedClass($requestedValue);
				$coll = $newField->addWhere($coll);
			} else {
				return response()->json(['message' => 'Bad Request'], 400);
			}
		}

		return $coll->get();
	}
}