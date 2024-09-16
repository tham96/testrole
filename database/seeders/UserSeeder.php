<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::where('name', 'Admin')->first();

        User::create([
            'user' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'admin123',
            'role_id' => 1,
            'status' => "Active",
        ]);
    }
}
