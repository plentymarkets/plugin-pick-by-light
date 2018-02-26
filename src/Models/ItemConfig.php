<?php

namespace PickByLight\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Class ItemConfig
 *
 * @property string $deviceId
 * @property string $soapURL
 * @property int $userId
 * @property string $ledId
 * @property string $currentLEDSpeed
 * @property string $nextLEDSpeed
 * @property array $colorRGB
 */
class ItemConfig extends Model
{
    public $deviceId = '';
    public $soapURL = '';
    public $userId = 0;
    public $ledId = '';
    public $currentLEDSpeed = '';
    public $nextLEDSpeed = '';
    public $colorRGB = [];
	
	public function toArray()
	{
		return [
			"deviceId" => $this->deviceId,
			"soapURL" => $this->soapURL,
			"userId" => $this->userId,
			"ledId" => $this->ledId,
			"currentLEDSpeed" => $this->currentLEDSpeed,
			"nextLEDSpeed" => $this->nextLEDSpeed,
			"colorRGB" => $this->colorRGB
		];
	}
}