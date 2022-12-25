<?php

namespace Database\Seeders;

use App\Models\PackageType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PackageType::create([
            'name' => 'Food'
        ]);
        PackageType::create([
            'name' => 'Electronics'
        ]);
        PackageType::create([
            'name' => 'Clothing'
        ]);
        PackageType::create([
            'name' => 'Documents'
        ]);
        PackageType::create([
            'name' => 'Parcel'
        ]);
        PackageType::create([
            'name' => 'Others'
        ]);
    }
}