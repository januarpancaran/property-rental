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
        // Get all landlords (role_id = 2)
        $landlords = User::where('role_id', 2)->get();

        if ($landlords->isEmpty()) {
            $this->command->warn('⚠️ No users with landlord role found.');
            return;
        }

        // Property types to randomize
        $propertyTypes = ['apartment', 'house', 'condo', 'townhouse', 'studio'];

        // Cities in Indonesia
        $cities = [
            ['city' => 'Jakarta', 'state' => 'DKI Jakarta', 'postal_code' => '10110'],
            ['city' => 'Bandung', 'state' => 'West Java', 'postal_code' => '40111'],
            ['city' => 'Surabaya', 'state' => 'East Java', 'postal_code' => '60111'],
            ['city' => 'Semarang', 'state' => 'Central Java', 'postal_code' => '50111'],
            ['city' => 'Yogyakarta', 'state' => 'DI Yogyakarta', 'postal_code' => '55111'],
        ];

        foreach (range(1, 15) as $i) {
            // Randomly select a landlord
            $randomLandlord = $landlords->random();

            // Randomly select a property type
            $randomPropertyType = $propertyTypes[array_rand($propertyTypes)];

            // Randomly select a city
            $randomCity = $cities[array_rand($cities)];

            // Adjust property characteristics based on type
            $bedrooms = match ($randomPropertyType) {
                'studio' => 0,
                'apartment' => rand(1, 3),
                'condo' => rand(2, 4),
                'house' => rand(3, 6),
                'townhouse' => rand(2, 5),
                default => rand(1, 3)
            };

            $bathrooms = match ($randomPropertyType) {
                'studio' => 1,
                'apartment' => rand(1, 2),
                'condo' => rand(2, 3),
                'house' => rand(2, 4),
                'townhouse' => rand(1, 3),
                default => rand(1, 2)
            };

            $areaSqm = match ($randomPropertyType) {
                'studio' => rand(20, 35),
                'apartment' => rand(35, 80),
                'condo' => rand(80, 150),
                'house' => rand(150, 300),
                'townhouse' => rand(60, 200),
                default => rand(50, 150)
            };

            $rentAmount = match ($randomPropertyType) {
                'studio' => rand(1500000, 3000000),
                'apartment' => rand(3000000, 6000000),
                'condo' => rand(5000000, 10000000),
                'house' => rand(10000000, 25000000),
                'townhouse' => rand(4000000, 12000000),
                default => rand(2000000, 8000000)
            };

            Property::create([
                'user_id' => $randomLandlord->id,
                'title' => "Comfortable " . ucfirst($randomPropertyType) . " in " . $randomCity['city'],
                'description' => "A comfortable and strategic {$randomPropertyType} located in {$randomCity['city']}. " .
                    "Perfect for families or professionals. Close to public facilities and amenities.",
                'address' => "Jl. Merdeka No." . rand(1, 100),
                'city' => $randomCity['city'],
                'state' => $randomCity['state'],
                'postal_code' => $randomCity['postal_code'],
                'property_type' => $randomPropertyType,
                'rent_amount' => $rentAmount,
                'bedrooms' => $bedrooms,
                'bathrooms' => $bathrooms,
                'area_sqm' => $areaSqm,
                'status' => 'available',
            ]);
        }
    }
}
