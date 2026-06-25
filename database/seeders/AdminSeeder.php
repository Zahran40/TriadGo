<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user for Filament panel
        User::create([
            'name' => 'Admin TriadGo',
            'email' => 'admin@triadgo.com',
            'password' => Hash::make('admin123'),
            'phone' => '+6289999999999',
            'country' => 'Indonesia',
            'role' => 'admin',
            'profile_picture' => null,
        ]);

        $this->command->info('✅ Admin user created successfully!');
        $this->command->info('📧 Email: admin@triadgo.com');
        $this->command->info('🔐 Password: admin123');
    }
}
