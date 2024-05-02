<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $role = Role::create([ 'name' => User::ROLE_INSPECTOR, ]);

        User::factory()->create([
            'name' => 'Admin Inspector',
            'email' => 'inspector@inspecto-villa.com',
        ])->assignRole($role);

    }
}
