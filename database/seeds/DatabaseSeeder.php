<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        User::create([
            'name'     => 'John Rambo',
            'email'    => 'john@rambo.com',
            'password' => bcrypt('test'),
            'role' => "admin",
            "deleted" => 0
        ]);
    }
}
