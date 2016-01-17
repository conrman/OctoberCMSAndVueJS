<?php namespace SublimeArts\DealerStore\Updates;

use Seeder;
use SublimeArts\DealerStore\Models\Product;

class SeedUsersTable extends Seeder
{
    public function run()
    {
        $product = Product::create([
            'name'          => 'Mojo',
            'code'          => 'mojo',
            'description'   => 'Lorem ipsum Consectetur pariatur Excepteur in consequat adipisicing sed fugiat consequat do Excepteur exercitation in Duis sint do et anim ad consequat ad velit quis pariatur est quis dolore deserunt consectetur nulla Duis ut minim nisi in dolor laborum officia voluptate Duis tempor exercitation culpa ullamco magna in non et quis cillum elit ad ut id est mollit fugiat Duis labore amet enim quis voluptate cupidatat incididunt est aute dolore do velit magna mollit ea laboris ut fugiat labore ut aliqua laborum dolor ad magna reprehenderit dolor nisi laboris cupidatat dolor ut culpa commodo reprehenderit officia est esse in Ut culpa ea sint occaecat proident proident Duis exercitation in commodo ut ea ex ea cillum consectetur est do reprehenderit quis sit dolor labore velit in proident voluptate nostrud occaecat consequat dolor deserunt laboris labore amet minim dolor reprehenderit ullamco mollit laboris eiusmod proident Ut labore irure mollit Ut elit proident ut ullamco eiusmod cillum enim eu magna in officia do qui ex do veniam non labore dolor ad consequat culpa Ut enim proident aute commodo nostrud adipisicing irure sit nostrud non dolor dolore qui Duis consequat in consectetur est dolor sit.',
            'fob_price'     => 200,
            'dealer_price'  => 300,
            'retail_price'  => 500,
            'is_activated'  => true
        ]);
        
        $product = Product::create([
            'name'          => 'FCB Mach 1',
            'code'          => 'fcb-mach-1',
            'description'   => 'Lorem ipsum Consectetur pariatur Excepteur in consequat adipisicing sed fugiat consequat do Excepteur exercitation in Duis sint do et anim ad consequat ad velit quis pariatur est quis dolore deserunt consectetur nulla Duis ut minim nisi in dolor laborum officia voluptate Duis tempor exercitation culpa ullamco magna in non et quis cillum elit ad ut id est mollit fugiat Duis labore amet enim quis voluptate cupidatat incididunt est aute dolore do velit magna mollit ea laboris ut fugiat labore ut aliqua laborum dolor ad magna reprehenderit dolor nisi laboris cupidatat dolor ut culpa commodo reprehenderit officia est esse in Ut culpa ea sint occaecat proident proident Duis exercitation in commodo ut ea ex ea cillum consectetur est do reprehenderit quis sit dolor labore velit in proident voluptate nostrud occaecat consequat dolor deserunt laboris labore amet minim dolor reprehenderit ullamco mollit laboris eiusmod proident Ut labore irure mollit Ut elit proident ut ullamco eiusmod cillum enim eu magna in officia do qui ex do veniam non labore dolor ad consequat culpa Ut enim proident aute commodo nostrud adipisicing irure sit nostrud non dolor dolore qui Duis consequat in consectetur est dolor sit.',
            'fob_price'     => 150,
            'dealer_price'  => 250,
            'retail_price'  => 450,
            'is_activated'  => true
        ]);
    }
}