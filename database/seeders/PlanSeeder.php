<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plans')->delete();

        $trial = "Trial Plan";
        $trial_slug = Str::slug($trial);
        $trial_description = "Unlimited Tech Stories & Updates,Access on all devices,Explore Unlimited Topics,Exclusive and High-quality contents,Stories based on your interests";

        $prem = "Premium Plan";
        $prem_slug = Str::slug($prem);
        $prem_description = "Unlimited Tech Stories & Updates,Limited Ads,Access on all devices,Explore Unlimited Topics,Exclusive and High-quality contents,Stories based on your interests,Cancel Premium Anytime";

        $data = array(
            [
                'title' => $trial,
                'allowable_days'    => '20',
                'slug'              => $trial_slug,
                'price'             => 0,
                'description'       => $trial_description
            ],
            [
                'title' => $prem,
                'allowable_days'    => '300',
                'slug'              => $prem_slug,
                'price'             => 300,
                'description'       => $prem_description
            ]
            );

        DB::table('plans')->insert($data);
    }
}
