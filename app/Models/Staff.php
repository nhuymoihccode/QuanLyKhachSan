<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staffs';

    protected $fillable = [
        'hotel_id',
        'name',
        'position',
        'phone',
        'email',
        'salary',
        'started_at',
    ];

    protected $casts = [
        'started_at' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }
}