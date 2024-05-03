<?php

namespace Database\Seeders;

use App\Models\InspectorLicense;
use App\Models\OfficeAddress;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Inspector User',
            'email' => 'inspector@example.com',
        ])->assignRole(
            Role::create([ 'name' => User::ROLE_INSPECTOR, ])
        );

        InspectorLicense::factory()->create([
            'user_id' => $user->id,
        ]);

        OfficeAddress::factory()->create([
            'user_id' => $user->id,
        ]);

        $buyerUser = User::factory()->create([
            'name' => 'Buyer User',
            'email' => 'buyer@example.com',
        ])->assignRole(
            Role::create([ 'name' => User::ROLE_BUYER, ])
        );

        Property::factory(2)->create([
            'buyer_id' => $buyerUser->id,
        ]);
    }
}
