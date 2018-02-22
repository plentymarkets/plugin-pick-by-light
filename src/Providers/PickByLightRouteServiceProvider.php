<?php

namespace PickByLight\Providers;

use Plenty\Plugin\Routing\ApiRouter;
use Plenty\Plugin\RouteServiceProvider;

class PickByLightRouteServiceProvider extends RouteServiceProvider
{
    /**
     * @param ApiRouter $router
     */
    public function map(ApiRouter $router)
    {
        $router->version(['v1'], ['namespace' => 'PickByLight\Controllers', 'middleware' => 'oauth'],
            function ($router) {
                $router->post('fulfillment/pickByLight/settings/', 'SettingsController@saveSettings');
                $router->get('fulfillment/pickByLight/settings/', 'SettingsController@loadSettings');
            });
    }
}