<?php


namespace iAmirNet\BehPardakht\Models;

use Model;

class BehPardakhtSettings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];
    public $settingsCode = 'iamirnet_gateways_settings';
    public $settingsFields = '$/iamirnet/behpardakht/models/settings/fields_behpardakht.yaml';
}