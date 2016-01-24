<?php namespace SublimeArts\Dealers\Updates;

use SublimeArts\Dealers\Models\Dealer;
use October\Rain\Database\Updates\Seeder;
use Hash, Carbon\Carbon;

class SeedDealersTable extends Seeder
{
    public function run()
    {
        $password = Hash::make('tester');
        Dealer::create([
            'username' => 'testdealer1',
            'dealers_group_id' => '1',
            'email' => 'tester1@dealer.com',
            'company_name' => 'Test Dealer 1',
            'password' => $password,
            'password_confirmation' => $password,
            'is_activated' => true,
            'activated_at' => Carbon::now(),
            'membership_requested_at' => Carbon::now()
        ]);

        Dealer::create([
            'username' => 'testdealer2',
            'dealers_group_id' => '1',
            'email' => 'tester2@dealer.com',
            'company_name' => 'Test Dealer 2',
            'password' => $password,
            'password_confirmation' => $password,
            'is_activated' => true,
            'activated_at' => Carbon::now(),
            'membership_requested_at' => Carbon::now()
        ]);
    }
}
