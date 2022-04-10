<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Eloquent;

class Availability extends Eloquent
{
    use HasFactory;

    protected $table = 'availabilities';

    protected $fillable = [
        'user_id',
        'kost_id',
        'owner_id',
        'status',
        'is_available'
    ];

    public function kost() {
        return $this->belongsTo(Kost::class, 'kost_id', 'id');
    }
}
