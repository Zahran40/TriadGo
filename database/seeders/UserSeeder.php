<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // ✅ 20 USERS TOTAL: 10 Exporters + 10 Importers
        $users = [
            // 🏭 EXPORTERS (10 users) - From various SEA countries
            [
                'name' => 'Ahmad Rizki Pratama',
                'email' => 'ahmad.rizki@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '+6281234567890',
                'country' => 'Indonesia',
                'role' => 'ekspor',
                'profile_picture' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face',
            ],
            [
                'name' => 'Maria Santos Cruz',
                'email' => 'maria.santos@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '+639171234567',
                'country' => 'Philippines',
                'role' => 'ekspor',
                'profile_picture' => 'https://images.unsplash.com/photo-1494790108755-2616b9c4d3c1?w=150&h=150&fit=crop&crop=face',
            ],
            [
                'name' => 'Somchai Thanakit',
                'email' => 'somchai.thai@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '+66891234567',
                'country' => 'Thailand',
                'role' => 'ekspor',
                'profile_picture' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face',
            ],
            [
                'name' => 'Nguyen Van Duc',
                'email' => 'nguyen.duc@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '+84901234567',
                'country' => 'Vietnam',
                'role' => 'ekspor',
                'profile_picture' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&h=150&fit=crop&crop=face',
            ],
            [
                'name' => 'Lim Wei Ming',
                'email' => 'lim.weiming@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '+60123456789',
                'country' => 'Malaysia',
                'role' => 'ekspor',
                'profile_picture' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face',
            ],
            [
                'name' => 'Sari Indrawati',
                'email' => 'sari.indra@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '+6281345678901',
                'country' => 'Indonesia',
                'role' => 'ekspor',
                'profile_picture' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop&crop=face',
            ],
            [
                'name' => 'Roberto Dela Cruz',
                'email' => 'roberto.dela@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '+639182345678',
                'country' => 'Philippines',
                'role' => 'ekspor',
                'profile_picture' => 'https://images.unsplash.com/photo-1519345182560-3f2917c472ef?w=150&h=150&fit=crop&crop=face',
            ],
            [
                'name' => 'Siriporn Kanjana',
                'email' => 'siriporn.kan@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '+66892345678',
                'country' => 'Thailand',
                'role' => 'ekspor',
                'profile_picture' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&h=150&fit=crop&crop=face',
            ],
            [
                'name' => 'Tran Minh Hoang',
                'email' => 'tran.hoang@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '+84902345678',
                'country' => 'Vietnam',
                'role' => 'ekspor',
                'profile_picture' => null,
            ],
            [
                'name' => 'Fatimah Binti Ahmad',
                'email' => 'fatimah.ahmad@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '+60124567890',
                'country' => 'Malaysia',
                'role' => 'ekspor',
                'profile_picture' => 'https://images.unsplash.com/photo-1494790108755-2616b9c4d3c1?w=150&h=150&fit=crop&crop=face',
            ],

            // 🛒 IMPORTERS (10 users) - From various SEA countries
            [
                'name' => 'John Smith Anderson',
                'email' => 'john.anderson@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '+6598765432',
                'country' => 'Singapore',
                'role' => 'impor',
                'profile_picture' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face',
            ],
            [
                'name' => 'Chen Wei Li',
                'email' => 'chen.weili@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '+6587654321',
                'country' => 'Singapore',
                'role' => 'impor',
                'profile_picture' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face',
            ],
            [
                'name' => 'Isabella Rodriguez',
                'email' => 'isabella.rodriguez@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '+639198765432',
                'country' => 'Philippines',
                'role' => 'impor',
                'profile_picture' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop&crop=face',
            ],
            [
                'name' => 'Kittipong Srisawat',
                'email' => 'kittipong.sri@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '+66893456789',
                'country' => 'Thailand',
                'role' => 'impor',
                'profile_picture' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&h=150&fit=crop&crop=face',
            ],
            [
                'name' => 'Le Thi Mai',
                'email' => 'le.mai@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '+84903456789',
                'country' => 'Vietnam',
                'role' => 'impor',
                'profile_picture' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&h=150&fit=crop&crop=face',
            ],
            [
                'name' => 'Ahmad Fauzi Rahman',
                'email' => 'ahmad.fauzi@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '+60125678901',
                'country' => 'Malaysia',
                'role' => 'impor',
                'profile_picture' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face',
            ],
            [
                'name' => 'Dewi Kusuma Sari',
                'email' => 'dewi.kusuma@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '+6281456789012',
                'country' => 'Indonesia',
                'role' => 'impor',
                'profile_picture' => 'https://images.unsplash.com/photo-1494790108755-2616b9c4d3c1?w=150&h=150&fit=crop&crop=face',
            ],
            [
                'name' => 'Marcus Tan Wei Hao',
                'email' => 'marcus.tan@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '+6589876543',
                'country' => 'Singapore',
                'role' => 'impor',
                'profile_picture' => null,
            ],
            [
                'name' => 'Priya Sharma Nair',
                'email' => 'priya.sharma@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '+66894567890',
                'country' => 'Thailand',
                'role' => 'impor',
                'profile_picture' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop&crop=face',
            ],
            [
                'name' => 'Budi Santoso Wijaya',
                'email' => 'budi.santoso@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '+6281567890123',
                'country' => 'Indonesia',
                'role' => 'impor',
                'profile_picture' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&h=150&fit=crop&crop=face',
            ],
        ];

        $totalUsers = 0;
        $exporterCount = 0;
        $importerCount = 0;

        foreach ($users as $userData) {
            try {
                User::create($userData);
                
                if ($userData['role'] === 'ekspor') {
                    $exporterCount++;
                    $roleIcon = '🏭';
                } else {
                    $importerCount++;
                    $roleIcon = '🛒';
                }
                
                $totalUsers++;
                $profileStatus = $userData['profile_picture'] ? '📸' : '👤';
                $this->command->info("{$roleIcon} {$profileStatus} {$userData['name']} ({$userData['country']}) - {$userData['phone']}");
                
            } catch (\Exception $e) {
                $this->command->error("❌ Error creating user " . $userData['name'] . ": " . $e->getMessage());
                continue;
            }
        }

        // ✅ DISPLAY STATISTICS
        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->command->info("🎉 USERS SEEDING COMPLETED SUCCESSFULLY! 🎉");
        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->command->info("👥 Total Users Created: {$totalUsers}");
        $this->command->info("🏭 Exporters: {$exporterCount}");
        $this->command->info("🛒 Importers: {$importerCount}");
        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");

        // ✅ USERS BY COUNTRY
        $this->command->info("🌏 USERS BY COUNTRY:");
        $countryCounts = [];
        foreach ($users as $user) {
            $country = $user['country'];
            if (!isset($countryCounts[$country])) {
                $countryCounts[$country] = ['total' => 0, 'exporters' => 0, 'importers' => 0];
            }
            $countryCounts[$country]['total']++;
            if ($user['role'] === 'ekspor') {
                $countryCounts[$country]['exporters']++;
            } else {
                $countryCounts[$country]['importers']++;
            }
        }

        foreach ($countryCounts as $country => $counts) {
            $flag = $this->getCountryFlag($country);
            $this->command->info("   {$flag} {$country}: {$counts['total']} users ({$counts['exporters']} exporters, {$counts['importers']} importers)");
        }

        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->command->info("🚀 Perfect balance! Now products and comments will be distributed evenly.");
        $this->command->info("📊 Expected distribution: ~5-6 products per exporter, ~3-4 comments per product");
        $this->command->info("🔐 All users password: 'password123'");
        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
    }

    private function getCountryFlag($country)
    {
        $flags = [
            'Indonesia' => '🇮🇩',
            'Philippines' => '🇵🇭',
            'Thailand' => '🇹🇭',
            'Vietnam' => '🇻🇳',
            'Malaysia' => '🇲🇾',
            'Singapore' => '🇸🇬',
        ];
        
        return $flags[$country] ?? '🌏';
    }
}