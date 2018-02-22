<?php

namespace PickByLight\Migrations;

use PickByLight\Models\Database\Settings;
use Plenty\Modules\Plugin\DataBase\Contracts\Migrate;

class CreateSettingsTable
{
    public function run(Migrate $migrate)
    {
        // Create the settings table
        try {
            $migrate->deleteTable(Settings::class);
        } catch (\Exception $e) {
            // Table does not exist
        }

        $migrate->createTable(Settings::class);
    }
}