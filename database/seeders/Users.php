<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Enums\UserTypes;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'admin@yahoo.com',
            'password' => bcrypt("admin123"),
            'country_id' => 92,
            'state_id' => 2787,
            'city_id' => 239,
            'zip_code' => "123456",
            'otp' => "1234",
            'contact_number' => "123123321",
            'status' => 1,
            'role_id' => UserTypes::Admin,
        ]);

        User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'moderator@yahoo.com',
            'password' => bcrypt("admin123"),
            'country_id' => 92,
            'state_id' => 2787,
            'city_id' => 239,
            'zip_code' => "123456",
            'otp' => "1234",
            'contact_number' => "123123321",
            'status' => 1,
            'role_id' => UserTypes::Moderator,
        ]);

        User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'user@yahoo.com',
            'password' => bcrypt("admin123"),
            'country_id' => 92,
            'state_id' => 2787,
            'city_id' => 239,
            'zip_code' => "123456",
            'otp' => "1234",
            'contact_number' => "123123321",
            'status' => 1,
            'role_id' => UserTypes::User,
        ]);
    }
}
