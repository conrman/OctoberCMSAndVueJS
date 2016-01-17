<?php namespace SublimeArts\DealerStore\Models;

use Model;

/**
 * LineItem Model
 */
class LineItem extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'sublimearts_dealerstore_line_items';

    
    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'product_id',
        'product_qty'
    ];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'product' => 'SublimeArts\DealerStore\Models\Product',
        'order' => 'SublimeArts\DealerStore\Models\Order'
    ];

}