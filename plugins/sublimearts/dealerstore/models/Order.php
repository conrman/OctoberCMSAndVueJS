<?php namespace SublimeArts\DealerStore\Models;

use Model, Log;
use Illuminate\Support\Collection;
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
        'tentative_shipping_on',
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

    public function updateTotal()
    {
        $lineItems = $this->lineItems;
        $this->total_value = 0;
        
        foreach($lineItems as $lineItem) {
            $this->total_value += $lineItem->value;
        }

        $this->save();
    }

    public function getProducts()
    {
        $products = [];
        $lineItems = $this->lineItems;

        foreach($lineItems as $lineItem)
        {
            $product = $lineItem->product->first();
            array_push($products, $product);
        }

        return $products;
        // return Collection::make($products);
    }

    public function afterSave()
    {
        if(!$this->is_shipped)
        {
            $this->shipping_provider = $this->tracking_number = null;
        }
    }

}