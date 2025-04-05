<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'room_id',
        'name',
        'type',
        'status',
    ];
    public function room()
    {
        return $this->belongsTo(Room::class, 'id');
    }
}
