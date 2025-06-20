<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $message
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
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
