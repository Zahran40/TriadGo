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
        // 3 Users dengan role Importir
        $importers = [
            [
                'name' => 'Ahmad Importir',
                'email' => 'ahmad.importir@example.com',
                'password' => Hash::make('password123'),
                'phone' => '+62812345678901',
                'country' => 'Indonesia',
                'role' => 'impor',
                'profile_picture' => null,
            ],
            [
                'name' => 'Siti Importir',
                'email' => 'siti.importir@example.com',
                'password' => Hash::make('password123'),
                'phone' => '+60123456789',
                'country' => 'Malaysia',
                'role' => 'impor',
                'profile_picture' => null,
            ],
            [
                'name' => 'John Importer',
                'email' => 'john.importer@example.com',
                'password' => Hash::make('password123'),
                'phone' => '+6591234567',
                'country' => 'Singapore',
                'role' => 'impor',
                'profile_picture' => null,
            ],
        ];

        // 3 Users dengan role Eksportir
        $exporters = [
            [
                'name' => 'Budi Eksportir',
                'email' => 'budi.eksportir@example.com',
                'password' => Hash::make('password123'),
                'phone' => '+62812345678902',
                'country' => 'Indonesia',
                'role' => 'ekspor',
                'profile_picture' => null,
            ],
            [
                'name' => 'Maria Eksportir',
                'email' => 'maria.eksportir@example.com',
                'password' => Hash::make('password123'),
                'phone' => '+6312345678',
                'country' => 'Philippines',
                'role' => 'ekspor',
                'profile_picture' => null,
            ],
            [
                'name' => 'David Exporter',
                'email' => 'david.exporter@example.com',
                'password' => Hash::make('password123'),
                'phone' => '+6612345678',
                'country' => 'Thailand',
                'role' => 'ekspor',
                'profile_picture' => null,
            ],
        ];

        // Insert Importers
        foreach ($importers as $importer) {
            User::create($importer);
        }

        // Insert Exporters
        foreach ($exporters as $exporter) {
            User::create($exporter);
        }

        $this->command->info('3 Importers and 3 Exporters created successfully!');
    }
}