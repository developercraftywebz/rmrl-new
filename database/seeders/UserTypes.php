<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserRole;

class UserTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserRole::create(['name' => 'User', 'description' => 'user']);
        UserRole::create(['name' => 'Moderator', 'description' => 'moderator']);
        UserRole::create(['name' => 'Admin', 'description' => 'admin']);
    }
}
