<?php namespace Denora\Letterwriting\Models;

use Model;

class Settings extends  Model {

    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'denora_letterwriting_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';

}