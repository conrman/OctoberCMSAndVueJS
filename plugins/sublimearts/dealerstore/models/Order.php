<?php namespace SublimeArts\DealerStore\Models;

use Model;
use SublimeArts\DealerStore\Models\LineItem;

/**
 * Order Model
 */
class Order extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'sublimearts_dealerstore_orders';

    protected $dates = ['shipped_on'];
    
    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'dealer_id',
        'shipped_on',
        'shipping_provider',
        'tracking_number',
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

    public function beforeSave() {
        $lineItems = $this->lineItems;
        $this->total_value = 0;
        
        foreach($lineItems as $lineItem) {
            $this->total_value += $lineItem->value;
        }
    }

    public function afterSave() {
        // Delete any Orphan LineItems
        LineItem::where('order_id', null)->delete();
    }
    
}