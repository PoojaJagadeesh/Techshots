<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'  => 'Super Admin',
            'email' => 'admin@techshot.com',
            'password' => Hash::make('superadmin@techshot')
        ];
    }
}
