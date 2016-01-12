<?php namespace SublimeArts\Forms\Models;

use Model;

/**
 * Lead Model
 */
class Lead extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'sublimearts_forms_leads';

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'fullname',
        'email',
        'type',
        'message',
        'subscribed',
        'subscribed_at'
    ];

    public $dates = ['subscribed_at'];

}