<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $admin = User::create([
            'name' => 'admin',
            'email'=> 'admin@gmail.com',
            'nohp'=> '1',
            'password'=> bcrypt('admin123')
        ]);
        $admin->assignRole('admin');

        $user = User::create([
            'name' => 'Christina Hutahaean',
            'email' => 'christinahutahaean24@gmail.com',
            'nohp'=> '6285261855148',
            'password'=> bcrypt('christina333')
        ],
        [
            'name' => 'Jesika Purba',
            'email'=> 'jesikaofficial4@gmail.com',
            'nohp'=> '627890782107',
            'password'=> bcrypt('jesika111')

        ],
        [
            'name' => 'Glory hutahaean',
            'email' => 'gloryhutahaean12@gmail.com',
            'nohp'=> '627890782179',
            'password'=> bcrypt('glory222')

        ],
    );

        $user->assignRole('customer');
    }
}
