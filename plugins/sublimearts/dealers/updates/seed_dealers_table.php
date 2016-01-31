<?php namespace SublimeArts\Dealers\Updates;

use SublimeArts\Dealers\Models\Dealer;
use October\Rain\Database\Updates\Seeder;
use Hash, Carbon\Carbon;

class SeedDealersTable extends Seeder
{
    public function run()
    {
        $password = 'tester';
        
        Dealer::create([
            'username' => 'testdealer1',
            'email' => 'tester1@dealer.com',
            'company_name' => 'Test Dealer 1',
            'password' => $password,
            'password_confirmation' => $password,
            'is_activated' => true,
            'activated_at' => Carbon::now(),
            'phone' => '+1 123 456 7890',
            'contact_person_first_name' => 'John',
            'contact_person_last_name' => 'Doe',
            'contact_person_email' => 'john.doe@testerdealer1.com'
        ]);

        Dealer::create([
            'username' => 'testdealer2',
            'dealers_group_id' => '1',
            'email' => 'tester2@dealer.com',
            'company_name' => 'Test Dealer 2',
            'password' => $password,
            'password_confirmation' => $password,
            'phone' => '+1 098 765 4321',
            'contact_person_first_name' => 'Caleb',
            'contact_person_last_name' => 'Doe',
            'contact_person_email' => 'caleb.doe@testerdealer2.com'
        ]);
    }
}
