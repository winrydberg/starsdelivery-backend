<?php

namespace Database\Seeders;

use App\Models\DeliveryMode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DeliveryMode::create([
            'name' => 'Motocycle',
            'slug' => 'motocycle',
            'image' => 'public/mode/motorcycle.png',
            'amount_per_km' => 2.0
        ]);

         DeliveryMode::create([
            'name' => 'Car',
            'slug' => 'car',
            'image' => 'public/mode/car.png',
            'amount_per_km' => 5.0
         ]);
    }
}