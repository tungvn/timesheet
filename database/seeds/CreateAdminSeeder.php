<?php

use App\User;
use Illuminate\Database\Seeder;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username'          => 'admin',
            'email'             => 'tung-vu@dimage.co.jp',
            'password'          => '2@z*HUM5PQ',
            'role'              => User::ROLE_ADMIN,
            'email_verified_at' => now(),
            'description'       => 'The administrator created by seeder',
        ]);
    }
}
