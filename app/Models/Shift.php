<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable = ['staff_id', 'start_time', 'end_time', 'date'];

    protected $casts = [
        'start_time' => 'datetime:H:i', // Cast thành datetime và định dạng giờ H:i
        'end_time' => 'datetime:H:i',   // Cast thành datetime và định dạng giờ H:i
        'date' => 'date',               // Cast cột date thành date
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}