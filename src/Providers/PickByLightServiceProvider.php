<?php

namespace PickByLight\Providers;

use PickByLight\Helpers\PickByLightHelper;
use PickByLight\Models\ItemConfig;
use Plenty\Modules\Fulfillment\Picklist\Events\GetPickingItemConfig;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ServiceProvider;

/**
 * Class PickByLightServiceProvider
 * @package PickByLight\Providers
 */
class PickByLightServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->getApplication()->register(PickByLightRouteServiceProvider::class);
    }

    /**
     * @param Dispatcher $eventDispatcher
     * @param PickByLightHelper $pickByLightHelper
     */
    public function boot(
        Dispatcher $eventDispatcher,
        PickByLightHelper $pickByLightHelper
    ) {
        $eventDispatcher->listen(GetPickingItemConfig::class,
            function (GetPickingItemConfig $event) use ($eventDispatcher, $pickByLightHelper) {
                /** @var ItemConfig $itemConfig */
                $itemConfig = $pickByLightHelper->getSingleItemConfig($event->getProcessUserId(),
                    $event->getPickingOrderItemId());

                $event->addPluginConfig('pluginName', (array)$itemConfig);
            });
    }
}