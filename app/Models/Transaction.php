<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function trackingDetail($id)
    {
        $transaction = Transaction::findOrFail($id); // Jika tidak ketemu, otomatis 404
        return view('trackingekspor', compact('transaction'));
    }

    public function trackings()
    {
        return $this->hasMany(Tracking::class);
    }
}
