<?php

namespace PickByLight\Controllers;

use PickByLight\Services\Database\SettingsService;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;

/**
 * Class SettingsController
 * @package PickByLight\Controllers
 */
class SettingsController extends Controller
{
    /**
     * @var SettingsService
     */
    private $settingsService;

    /**
     * SettingsController constructor.
     * @param SettingsService $settingsService
     */
    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function saveSettings(Request $request)
    {
        return json_encode($this->settingsService->saveSettings($request->get('warehouseId'), $request->get('settings'),
            $request->get('config')));
    }

    /**
     * @param Request $request
     * @return string
     */
    public function loadSettings(Request $request)
    {
        return json_encode($this->settingsService->loadSettings($request->get('warehouseId')));
    }
}