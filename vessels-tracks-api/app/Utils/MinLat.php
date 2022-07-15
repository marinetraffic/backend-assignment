<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Builder;

class MinLat
{
	protected $value;

	function __construct(string $value)
	{
		$this->value = (float) $value;
	}

	public function addWhere(Builder $coll)
	{
		return $coll->where('lat', '>=', $this->value);
	}
}