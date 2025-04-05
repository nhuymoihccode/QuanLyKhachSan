<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Thêm trường role để lưu vai trò người dùng
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Phương thức kiểm tra xem người dùng có phải là admin hay không.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin'; // Kiểm tra vai trò của người dùng
    }
    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'user_promotions', 'user_id', 'promotion_id')
            ->withPivot('claimed_at')
            ->withTimestamps();
    }
}