<?php namespace SublimeArts\Dealers\Models;

use Lang;
use Model;
use System\Models\MailTemplate;
use SublimeArts\Dealers\Models\Dealer as DealerModel;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'dealer_settings';
    public $settingsFields = 'fields.yaml';

    const ACTIVATE_AUTO = 'auto';
    const ACTIVATE_DEALER = 'dealer';
    const ACTIVATE_ADMIN = 'admin';

    const LOGIN_EMAIL = 'email';
    const LOGIN_USERNAME = 'username';

    public function initSettingsData()
    {
        $this->require_activation = true;
        $this->activate_mode = self::ACTIVATE_ADMIN;
        $this->use_throttle = true;
        $this->allow_registration = true;
        $this->welcome_template = 'sublimearts.dealers::mail.welcome';
        $this->login_attribute = self::LOGIN_EMAIL;
    }

    public function getActivateModeOptions()
    {
        return [
            self::ACTIVATE_AUTO => ['Auto', 'Automatic activation on registration.'],
            self::ACTIVATE_DEALER => ['Dealer', 'Dealers activate using emails sent to them.'],
            self::ACTIVATE_ADMIN => ['Admin', 'Manual activation by admins.'],
        ];
    }

    public function getLoginAttributeOptions()
    {
        return [
            self::LOGIN_EMAIL => ['email'],
            self::LOGIN_USERNAME => ['username'],
        ];
    }

    public function getActivateModeAttribute($value)
    {
        if (!$value) {
            return self::ACTIVATE_AUTO;
        }

        return $value;
    }

    public function getWelcomeTemplateOptions()
    {
        $codes = array_keys(MailTemplate::listAllTemplates());
        $result = [''=>'- ' . 'No Mail Templates' . ' -'];
        $result += array_combine($codes, $codes);
        return $result;
    }
}