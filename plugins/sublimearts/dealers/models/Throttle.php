<?php namespace SublimeArts\Dealers\Models;

use Model;

/**
 * Throttle Model
 */
class Throttle extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'sublimearts_dealers_throttles';

    /**
     * @var array Relations
     */
    /**
     * @var array Relations
     */
    public $belongsTo = [
        'dealer' => ['SublimeArts\Dealers\Models\Dealer']
    ];

}