<?php

use Illuminate\Database\Seeder;
use \App\User;
use \App\Movie;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a dummy user.
        $user = User::create([
            'name' => 'Test',
            'email' => 'test@hotmail.com',
            'password' => Hash::make('testtest')
        ]);

        // Create a few dummy movies that the user has (not) seen.
        Movie::create([
            'title' => 'John Wick',
            'seen' => '1',
            'user_id' => $user->id
        ]);

        Movie::create([
            'title' => 'Knives Out',
            'seen' => '0',
            'user_id' => $user->id
        ]);

        Movie::create([
            'title' => '1917',
            'seen' => '0',
            'user_id' => $user->id
        ]);
    }
}
