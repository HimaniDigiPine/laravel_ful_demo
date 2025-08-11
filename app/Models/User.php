<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'firstname',
        'lastname',
        'name', // auto: firstname + lastname
        'email',
        'phonenumber',
        'role',
        'password',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Accessor for full name (optional)
    public function getFullNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    // Set full name automatically when firstname or lastname changes
    protected static function booted()
    {
        static::creating(function ($user) {
            $user->name = $user->firstname . ' ' . $user->lastname;
        });

        static::updating(function ($user) {
            $user->name = $user->firstname . ' ' . $user->lastname;
        });
    }
}