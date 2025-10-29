<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\User;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

    foreach (range(1, 5) as $i) {
        Property::create([
            'user_id' => $users->random()->id, // ambil user acak
            'title' => "Rumah Nyaman #{$i}",
            'description' => "Deskripsi singkat untuk rumah ke-{$i}",
            'address' => "Jl. Contoh No.{$i}",
            'city' => "Jakarta",
            'state' => "DKI Jakarta",
            'postal_code' => "10110",
            'property_type' => "house",
            'rent_amount' => rand(1000000, 9000000),
            'bedrooms' => rand(1, 5),
            'bathrooms' => rand(1, 3),
            'area_sqm' => rand(50, 200),
            'status' => "available",
        ]);
    }
    }
}
