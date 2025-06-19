<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'nomor_resi',
        'negara_tujuan',
        'status',
        'estimasi_sampai'
    ];
}