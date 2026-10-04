<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasUuids, Notifiable;

    protected $fillable = ['role_id', 'agency_id', 'name', 'email', 'password_hash', 'google_id', 'password_login_enabled', 'is_active'];
    protected $hidden = ['password_hash'];
    protected $casts = ['is_active' => 'boolean', 'password_login_enabled' => 'boolean'];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}