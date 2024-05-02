<?php

namespace Database\Seeders;

use App\Models\OfficeAddress;
use App\Models\InspectorLicense;
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
            'name' => 'Admin Inspector',
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
    }
}
