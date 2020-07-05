<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'First User',
            'email' => 'first_user@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('secret'),
            'role' => 0
        ]);
    }
}
