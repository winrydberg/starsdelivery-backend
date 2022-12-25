<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentType::create([
            'name' => 'MTN Mobile Money',
            'type' => 'momo',
            'image' => 'public/payment/mtn.png'
        ]);
        PaymentType::create([
            'name' => 'Vodafone Cash',
            'type' => 'momo',
            'image' => 'public/payment/vodafone.png'
        ]);
        PaymentType::create([
            'name' => 'AirtelTigo Money',
            'type' => 'momo',
            'image' => 'public/payment/tigo.png'
        ]);
        PaymentType::create([
            'name' => 'Cash On Delivery',
            'type' => 'cash',
            'image' => 'public/payment/cash.png'
        ]);
    }
}