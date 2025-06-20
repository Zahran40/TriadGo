<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        Transaction::insert([
            [
                'user_id' => 1,
                'nomor_resi' => 'TRX001',
                'negara_tujuan' => 'Singapura',
                'status' => 'Menunggu',
                'estimasi_sampai' => '2024-07-01',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'nomor_resi' => 'TRX002',
                'negara_tujuan' => 'Jepang',
                'status' => 'Dikirim',
                'estimasi_sampai' => '2024-07-05',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'nomor_resi' => 'TRX003',
                'negara_tujuan' => 'Malaysia',
                'status' => 'Selesai',
                'estimasi_sampai' => '2024-06-25',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}