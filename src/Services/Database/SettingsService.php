<?php //strict

namespace PickByLight\Services\Database;

use PickByLight\Models\Database\Settings;
use Plenty\Modules\Plugin\DataBase\Contracts\Model;
use Plenty\Modules\Plugin\DataBase\Contracts\DataBase;
use Plenty\Modules\StockManagement\Warehouse\Management\Contracts\StorageLocationManagementRepositoryContract;
use Plenty\Modules\StockManagement\Warehouse\Management\Models\StorageLocation;
use Plenty\Repositories\Models\PaginatedResult;

/**
 * Class SettingsService
 * @package PickByLight\Services\Database
 */
class SettingsService
{
    /**
     * @var DataBase
     */
    public $dataBase;

    /**
     * SettingsService constructor.
     * @param DataBase $dataBase
     */
    public function __construct(DataBase $dataBase)
    {
        $this->dataBase = $dataBase;
    }

    /**
     * @param int $warehouseId
     * @return Model
     */
    public function loadSettings(int $warehouseId)
    {
        $result = $this->dataBase->find(Settings::class, $warehouseId);

        if (is_null($result)) {
            /** @var Settings $result */
            $result = pluginApp(Settings::class);
            $result->warehouseId = $warehouseId;
            $result->settings = $this->getEmptySettings();
            $result->config = $this->getBasicConfig($warehouseId);
        } elseif ($result instanceof Settings) {
            $loadedConfig = $result->config;
            $basicConfig = $this->getBasicConfig($warehouseId);
            $mergedConfig = [];

            if (!is_null($loadedConfig)) {
                foreach ($basicConfig as $basicValue) {
                    foreach ($loadedConfig as $loadedValue) {
                        if ($basicValue['id'] == $loadedValue['id']) {
                            $basicValue['ledId'] = $loadedValue['ledId'];
                            break;
                        }
                    }
                    $mergedConfig[] = $basicValue;
                }
            } else {
                $mergedConfig = $basicConfig;
            }

            $result->config = $mergedConfig;
        }

        return $result;
    }

    /**
     * @param int $warehouseId
     * @param array $settingsValue
     * @param array $config
     * @return Model
     */
    public function saveSettings(int $warehouseId, array $settingsValue, array $config)
    {
        /** @var Settings $settings */
        $settings = pluginApp(Settings::class);

        if(empty($settingsValue['currentLEDspeed'])){
            $settingsValue['currentLEDspeed'] = 'AlwaysOn';
        }

        if(empty($settingsValue['nextLEDspeed'])){
            $settingsValue['nextLEDspeed'] = 'Slow';
        }

        $settings->warehouseId = $warehouseId;
        $settings->settings = $settingsValue;
        $settings->config = $config;

        return $this->dataBase->save($settings);
    }

    /**
     * @param int $warehouseId
     * @return array
     */
    public function getBasicConfig(int $warehouseId)
    {
        $config = [];

        /** @var StorageLocationManagementRepositoryContract $storageContract */
        $storageContract = pluginApp(StorageLocationManagementRepositoryContract::class);

        $storageContract->setFilters(['warehouseId' => $warehouseId]);

        $columns = ['id', 'name'];

        /** @var PaginatedResult $storageLocations */
        $storageLocations = $storageContract->findStorageLocations(1, 250, $columns)->toArray();

        /** @var StorageLocation $storageLocation */
        foreach ($storageLocations['entries'] as $storageLocation) {
            $storageArray = $storageLocation->toArray();
            $storageArray['ledId'] = '';
            $config[] = $storageArray;
        }

        return $config;
    }

    /**
     * @return array
     */
    public function getEmptySettings()
    {
        $settings = [
            'deviceId' => '',
            'soapURL' => '',
            'currentLEDspeed' => '',
            'nextLEDspeed' => ''
        ];

        return $settings;
    }
}
