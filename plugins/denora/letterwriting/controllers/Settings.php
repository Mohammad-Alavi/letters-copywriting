<?php namespace Denora\Letterwriting\Controllers;

use Backend\Classes\Controller;
use Backend\Facades\BackendMenu;
use System\Classes\SettingsManager;

class Settings extends Controller {
    public $implement = ['Backend\Behaviors\FormController'];

    public $formConfig = 'config_form.yaml';

    public function __construct() {
        parent::__construct();

        BackendMenu::setContext('October.System', 'system', 'settings');
        SettingsManager::setContext('Denora.Letterwriting', 'denora_letterwriting_settings');

    }
}
