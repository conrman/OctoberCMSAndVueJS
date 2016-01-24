<?php namespace SublimeArts\DealerStore\Models;

use Model, Log;

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
        'product_qty',
        'value'
    ];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'product' => 'SublimeArts\DealerStore\Models\Product',
        'order' => 'SublimeArts\DealerStore\Models\Order'
    ];

    public function updateLineValue() 
    {
        $this->value = $this->product->dealer_price * $this->product_qty;
    }

    public function beforeSave()
    {
        $this->updateLineValue();
    }

    public function afterSave()
    {
        if($this->order) {
            $this->order->updateTotal();
        }
    }

    public function onLineItemAdd()
    {
        if($this->order) {
            $this->order->updateTotal();
        }
    }

}