<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'name',
        'discount_percentage',
        'start_date',
        'end_date',
        'quantity',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'discount_percentage' => 'decimal:2', // Sử dụng kiểu decimal với scale là 2
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('claimed_at');
    }
}