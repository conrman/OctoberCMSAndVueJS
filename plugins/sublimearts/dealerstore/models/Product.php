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

    protected $hidden = [
        'fob_price'
    ];

    /**
     * @var array Relations
     */
    public $hasMany = [
        'lineItems' => 'SublimeArts\DealerStore\Models\LineItem'
    ];

    public $attachOne = [
        'thumbnail_image' => 'System\Models\File'
    ];

    public $attachMany = [
        'product_images' => 'System\Models\File',
        'lifestyle_images' => 'System\Models\File'
    ];


    public function getThumbnailAttribute()
    {
        if($this->thumbnail_image) {
            $thumbUrl = $this->thumbnail_image->getThumb(100, 100, ['crop']);
        } else {
            $thumbUrl = 'http://placehold.it/100x100';
        }
        
        return '<img src="' . $thumbUrl . '" alt="' . $this->name . '" />';
    }

    public function scopeIsActivated($query)
    {
        return $query->where('is_activated', 1);
    }
   
}