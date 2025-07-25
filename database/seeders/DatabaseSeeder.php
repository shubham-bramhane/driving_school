<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // User::factory(10)->create();

        $superAdmin = array_column(modulesList(), 'slug');

        $superAdmin = array_fill_keys($superAdmin, 5);

        Role::create(['role' => 'SuperAdmin' , 'permission' => json_encode($superAdmin)]);
        Role::create(['role' => 'User']);

        User::factory()->create([
            'name' => 'SuperAdmin',
            'email' => 'testing@gmail.com',
            'password' => bcrypt('123456789'),
            'mobile_no' => '8857916707',
            'role_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'nidhi',
            'email' => 'nidhi@gmail.com',
            'password' => bcrypt('123456789'),
            'mobile_no' => '8857916708',
            'role_id' => 1,
        ]);
    }
}
