<?php namespace SublimeArts\DealerStore\Models;

use Model;

/**
 * Product Model
 */
class Product extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'sublimearts_dealerstore_products';

    
    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'fob_price',
        'dealer_price',
        'retail_price',
        'is_activated'
    ];

    /**
     * @var array Relations
     */
    public $hasMany = [
        'lineItems' => 'SublimeArts\DealerStore\Models\LineItem'
    ];
    
}