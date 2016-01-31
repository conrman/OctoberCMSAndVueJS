<?php namespace SublimeArts\Dealers\Classes;

use October\Rain\Auth\Manager as RainAuthManager;
use SublimeArts\Dealers\Models\Settings as DealerSettings;

class AuthManager extends RainAuthManager
{
    protected static $instance;

    protected $sessionKey = 'dealer_auth';

    protected $userModel = 'SublimeArts\Dealers\Models\Dealer';

    protected $groupModel = 'SublimeArts\Dealers\Models\DealerGroup';

    protected $throttleModel = 'SublimeArts\Dealers\Models\Throttle';

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