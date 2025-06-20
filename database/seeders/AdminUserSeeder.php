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
}

}
