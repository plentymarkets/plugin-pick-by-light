<?php

namespace PickByLight\Models\Database;

use Plenty\Modules\Plugin\DataBase\Contracts\Model;

/**
 * Class Settings
 *
 * @property int $warehouseId
 * @property array $settings
 * @property array $config
 * @property string $createdAt
 * @property string $updatedAt
 */
class Settings extends Model
{
    protected $autoIncrementPrimaryKey = false;

    protected $primaryKeyFieldName = 'warehouseId';

    public $warehouseId = 0;
    public $settings = [];
    public $config = [];
    public $createdAt = '';
    public $updatedAt = '';

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return 'PickByLight::settings';
    }
}