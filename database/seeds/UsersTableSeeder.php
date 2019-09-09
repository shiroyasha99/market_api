<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user1 = [
            'name' => 'Ahmed Rafie',
            'email' => 'ahmed@laravel.com',
            'password' => Hash::make('ahmed'),
            ];

        
            User::create($user1);
            // User::create($user2);
    }
}
