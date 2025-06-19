<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contactus extends Model
{
    //
    use Notifiable;

    use hasFactory;

    protected $table = 'contactus_tabel';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'message',
    ];

        protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

}
