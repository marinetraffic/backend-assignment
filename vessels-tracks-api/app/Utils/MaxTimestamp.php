<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Builder;

class MaxTimestamp
{
	protected $value;

	function __construct(string $value)
	{
		$this->value = (int) $value;
	}

	public function addWhere(Builder $coll)
	{
		return $coll->where('timestamp', '<=', $this->value);
	}
}