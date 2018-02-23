<?php

namespace PickByLight\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Class RGB
 *
 * @property int $r
 * @property int $g
 * @property int $b
 */
class RGB extends Model
{
    public $r = 0;
    public $g = 0;
    public $b = 0;
	
	public function toArray()
	{
		return [
			"r" => $this->r,
			"g" => $this->g,
			"b" => $this->b
		];
	}
}