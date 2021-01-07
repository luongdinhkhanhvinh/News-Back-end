<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        // Admin
        User::create([
            'first_name' => env('SEEDER_USER_FIRST_NAME', 'Alice'),
            'last_name' => env('SEEDER_USER_LAST_NAME', 'Publ'),
            'username' => env('SEEDER_USER_USERNAME', 'admin'),
            'password' => bcrypt((env('SEEDER_USER_PASSWORD', '123456'))),
            'email' => 'admin@publsoft.com',
            'image_name' => '3281b774-8fdc-4fe1-b542-57d07a4807b2.jpg',
            'is_admin' => true,
        ]);

        // Publisher
        User::create([
            'first_name' => 'John',
            'last_name' => 'Publ',
            'username' => 'publisher',
            'password' => bcrypt('123456'),
            'email' => 'john@publsoft.com',
            'image_name' => '4e386cf7-b1ad-40ca-835b-bf0e6a4903c8.jpg',
            'is_publisher' => true,
        ]);
    }
}
