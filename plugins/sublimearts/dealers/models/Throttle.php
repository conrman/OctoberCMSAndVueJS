<?php namespace SublimeArts\Dealers\Models;

use October\Rain\Auth\Models\Throttle as ThrottleBase;

class Throttle extends ThrottleBase
{
    /**
     * @var string The database table used by the model.
     */
    protected $table = 'sublimearts_dealers_throttles';

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'dealer' => ['SublimeArts\Dealers\Models\Dealer']
    ];
}
