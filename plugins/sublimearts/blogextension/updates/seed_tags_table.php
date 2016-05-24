<?php namespace SublimeArts\BlogExtension\Updates;

use SublimeArts\BlogExtension\Models\Tag;
use SublimeArts\DealerStore\Models\Product;
use October\Rain\Database\Updates\Seeder;

class SeedTagsTable extends Seeder
{
    public function run()
    {
        $products = Product::all();

        foreach($products as $product) {
            Tag::create([
                'name' => $product->name,
                'slug' => str_slug($product->name),
                'description' => $product->name . ' related posts.'
            ]);
        }
    }
}
