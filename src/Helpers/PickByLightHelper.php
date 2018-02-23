<?php //strict

namespace PickByLight\Helpers;

use PickByLight\Models\Database\Settings;
use PickByLight\Models\ItemConfig;
use PickByLight\Models\RGB;
use PickByLight\Services\Database\SettingsService;
use Plenty\Modules\Fulfillment\Picklist\Contracts\PickingOrderItemRepositoryContract;
use Plenty\Modules\Fulfillment\Picklist\Models\PickingOrderItem;
use Plenty\Modules\User\Contracts\UserRepositoryContract;
use Plenty\Modules\User\Models\User;

/**
 * Class PickByLightHelper
 * @package PickByLight\Helpers
 */
class PickByLightHelper
{
    /**
     * @var SettingsService
     */
    private $settingsService;

    /**
     * @var Settings
     */
    private $warehouseSettings = null;

    /**
     * PickByLightHelper constructor.
     * @param SettingsService $settingsService
     */
    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * @param int $warehouseId
     */
    private function loadWarehouseSettings(int $warehouseId)
    {
        $this->warehouseSettings = $this->settingsService->loadSettings($warehouseId);
    }

    /**
     * @param $userId
     * @param $orderItemId
     * @return ItemConfig
     */
    public function getSingleItemConfig($userId, $orderItemId)
    {
        /** @var ItemConfig $itemConfig */
        $itemConfig = pluginApp(ItemConfig::class);

        $itemConfig->userId = $userId;
        $itemConfig->colorRGB = (array)$this->getUserRGBcolor($userId);

        /** @var $pickingOrderItemContract PickingOrderItemRepositoryContract */
        $pickingOrderItemContract = pluginApp(PickingOrderItemRepositoryContract::class);

        /** @var PickingOrderItem $pickingOrderItem */
        $pickingOrderItem = $pickingOrderItemContract->getPickingOrderItemById($orderItemId);

        if (is_null($this->warehouseSettings) || $this->warehouseSettings->warehouseId != $pickingOrderItem->warehouseId) {
            $this->loadWarehouseSettings($pickingOrderItem->warehouseId);
        }

        $settings = $this->warehouseSettings->settings;

        $itemConfig->deviceId = $settings['deviceId'];
        $itemConfig->soapURL = $settings['soapURL'];
        $itemConfig->currentLEDspeed = $settings['currentLEDspeed'];
        $itemConfig->nextLEDspeed = $settings['nextLEDspeed'];

        foreach ($this->warehouseSettings->config as $config) {
            if ($config['id'] == $pickingOrderItem->holdingArea) {
                $itemConfig->ledId = $config['ledId'];
                break;
            }
        }

        return $itemConfig;
    }

    /**
     * @param $userId
     * @return RGB
     */
    public function getUserRGBcolor($userId)
    {
        /** @var RGB $rgb */
        $rgb = pluginApp(RGB::class);

        /** @var UserRepositoryContract $userContract */
        $userContract = pluginApp(UserRepositoryContract::class);

        /** @var User $user */
        $user = $userContract->getUserById($userId);

        $color = $user->color;

        $rgb->r = 160;
        $rgb->g = 170;
        $rgb->b = 30;

        return $rgb;
    }
}