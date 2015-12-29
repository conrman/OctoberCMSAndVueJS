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
            self::ACTIVATE_AUTO => ['sublimearts.dealers::lang.settings.activate_mode_auto', 'sublimearts.dealers::lang.settings.activate_mode_auto_comment'],
            self::ACTIVATE_DEALER => ['sublimearts.dealers::lang.settings.activate_mode_dealer', 'sublimearts.dealers::lang.settings.activate_mode_dealer_comment'],
            self::ACTIVATE_ADMIN => ['sublimearts.dealers::lang.settings.activate_mode_admin', 'sublimearts.dealers::lang.settings.activate_mode_admin_comment'],
        ];
    }

    public function getLoginAttributeOptions()
    {
        return [
            self::LOGIN_EMAIL => ['sublimearts.dealers::lang.login.attribute_email'],
            self::LOGIN_USERNAME => ['sublimearts.dealers::lang.login.attribute_username'],
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
        $result = [''=>'- '.Lang::get('sublimearts.dealers::lang.settings.no_mail_template').' -'];
        $result += array_combine($codes, $codes);
        return $result;
    }
}