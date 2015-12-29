<?php namespace SublimeArts\Dealers\Updates;

use SublimeArts\Dealers\Models\DealerGroup;
use October\Rain\Database\Updates\Seeder;

class SeedDealerGroupsTable extends Seeder
{
    public function run()
    {
        DealerGroup::create([
            'name' => 'No Discount',
            'code' => 'no-discount',
            'discount' => 0,
            'description' => 'No Discount over FOB group.'
        ]);
    }
}
