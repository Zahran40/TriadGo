<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user if doesn't exist
        $adminExists = User::where('email', 'admin@triadgo.com')->first();
        
        if (!$adminExists) {
            User::create([
                'name' => 'Admin TriadGO',
                'email' => 'admin@triadgo.com',
                'country' => 'Indonesia',
                'phone' => '+62812345678',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]);
            
            echo "Admin user created successfully!\n";
            echo "Email: admin@triadgo.com\n";
            echo "Password: admin123\n";
        } else {
            echo "Admin user already exists!\n";
        }
        
        // Create test eksportir
        $eksportirExists = User::where('email', 'eksportir@test.com')->first();
        if (!$eksportirExists) {
            User::create([
                'name' => 'Test Eksportir',
                'email' => 'eksportir@test.com',
                'country' => 'Indonesia',
                'phone' => '+62812345679',
                'password' => Hash::make('test123'),
                'role' => 'ekspor',
            ]);
            echo "Test eksportir created!\n";
        }
        
        // Create test importir
        $importirExists = User::where('email', 'importir@test.com')->first();
        if (!$importirExists) {
            User::create([
                'name' => 'Test Importir',
                'email' => 'importir@test.com',
                'country' => 'Malaysia',
                'phone' => '+60123456789',
                'password' => Hash::make('test123'),
                'role' => 'impor',
            ]);
            echo "Test importir created!\n";
        }
    }
}
