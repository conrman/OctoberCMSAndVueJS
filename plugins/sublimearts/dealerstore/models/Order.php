<?php namespace SublimeArts\DealerStore\Models;

use Model;

/**
 * Order Model
 */
class Order extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'sublimearts_dealerstore_orders';

    
    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'dealer_id',
        'total_value'
    ];

    /**
     * @var array Relations
     */
    public $hasMany = [
        'lineItems' => 'SublimeArts\DealerStore\Models\LineItem'
    ];

    public $belongsTo = [
        'dealer' => 'SublimeArts\Dealers\Models\Dealer'
    ];

    public $hasManyThrough = [
        'products' => [
            'SublimeArts\DealerStore\Models\Product',
            'through' => 'SublimeArts\DealerStore\Models\LineItem'
        ]
    ];

    public function getTotalValue()
    {
        $total = 0;
        foreach($this->lineItems as $lineItem) {
            $total += $lineItem->product->dealer_price * $lineItem->product_qty;
        }

        return $total;
    }
    
}