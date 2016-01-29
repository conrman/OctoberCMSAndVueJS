<?php namespace SublimeArts\DealerStore\Components;

use Cms\Classes\ComponentBase;
use SublimeArts\DealerStore\Models\Product;

class ProductDisplay extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'ProductDisplay Component',
            'description' => 'Displays all activated Products in the database.'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $products = Product::isActivated()->get();
        $this->page['products'] = $products;
    }

}