<?php namespace SublimeArts\Dealers\Models;

use October\Rain\Auth\Models\Group as GroupBase;

/**
 * DealerGroup Model
 */
class DealerGroup extends GroupBase
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'sublimearts_dealers_dealer_groups';

    /**
     * Validation rules
     */
    public $rules = [
        'name' => 'required|between:3,64',
        'code' => 'required|regex:/^[a-zA-Z0-9_\-]+$/|unique:sublimearts_dealers_dealer_groups',
    ];

    /**
     * @var array Relations
     */
    public $hasMany = [
        'dealers'       => ['SublimeArts\Dealers\Models\Dealer', 'key' => 'dealers_group_id'],
        'dealers_count' => ['SublimeArts\Dealers\Models\Dealer', 'key' => 'dealers_group_id', 'count' => true]
    ];

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'code',
        'discount',
        'description'
    ];

}