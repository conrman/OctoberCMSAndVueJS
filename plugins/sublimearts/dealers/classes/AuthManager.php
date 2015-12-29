<?php namespace SublimeArts\Dealers\Classes;

use October\Rain\Auth\Manager as RainAuthManager;
use SublimeArts\Dealers\Models\Settings as DealerSettings;

class AuthManager extends RainAuthManager
{
    protected static $instance;

    protected $sessionKey = 'user_auth';

    protected $userModel = 'RainLab\Dealers\Models\Dealer';

    protected $groupModel = 'RainLab\Dealers\Models\DealerGroup';

    protected $throttleModel = 'RainLab\Dealers\Models\Throttle';

    public function init()
    {
        $this->useThrottle = DealerSettings::get('use_throttle', $this->useThrottle);
        $this->requireActivation = DealerSettings::get('require_activation', $this->requireActivation);
        parent::init();
    }

    public function extendUserQuery($query)
    {
        $query->withTrashed();
    }
}