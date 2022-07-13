<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CommonSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('common_settings')->insert([
            'application_name' => 'Techshot Admin',
            'contact_number' => '9999999999',
            'daily_allowable_coins' => 2,
            'n_coins' => 100,
            'amount_per_n_coins' => 12.00,
            'currency' => 'INR',
        ]);
    }
}
