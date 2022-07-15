<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Builder;

class MMSI
{
	protected $value;

	function __construct(string|array $value)
	{
		if ( gettype($value) === 'string' ){
			$this->value = [(int) $value];
		} else {
			$this->value = $value;
		}
	}

	public function addWhere(Builder $coll)
	{
		return $coll->whereIn('mmsi', $this->value);
	}
}