<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    protected $fillable = ['transaction_id', 'status'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}