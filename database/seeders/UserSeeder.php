<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'              => 'Super Admin',
                'email'             => 'admin@animestreamer.com',
                'password'          => Hash::make('Admin@1234'),
                'email_verified_at' => now(),
            ],
            [
                'name'              => 'Naushad Rain',
                'email'             => 'naushad@animestreamer.com',
                'password'          => Hash::make('Naushad@1234'),
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }

        $this->command->info('✔  Users seeded successfully.');
        $this->command->table(
            ['Name', 'Email', 'Password'],
            [
                ['Super Admin',  'admin@animestreamer.com',   'Admin@1234'],
                ['Naushad Rain', 'naushad@animestreamer.com', 'Naushad@1234'],
            ]
        );
    }
}
