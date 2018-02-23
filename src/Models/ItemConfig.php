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
 * @property string $currentLEDspeed
 * @property string $nextLEDspeed
 * @property array $colorRGB
 */
class ItemConfig extends Model
{
    public $deviceId = '';
    public $soapURL = '';
    public $userId = 0;
    public $ledId = '';
    public $currentLEDspeed = '';
    public $nextLEDspeed = '';
    public $colorRGB = [];
	
	public function toArray()
	{
		return [
			"deviceId" => $this->deviceId,
			"soapURL" => $this->soapURL,
			"userId" => $this->userId,
			"ledId" => $this->ledId,
			"currentLEDspeed" => $this->currentLEDspeed,
			"nextLEDspeed" => $this->nextLEDspeed,
			"colorRGB" => $this->colorRGB
		];
	}
}