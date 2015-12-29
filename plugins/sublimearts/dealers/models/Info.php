<?php namespace SublimeArts\Dealers\Models;

use Model;

/**
 * Info Model
 */
class Info extends Model
{

    public $implement = ['RainLab.Location.Behaviors.LocationModel'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'sublimearts_dealers_info';

}