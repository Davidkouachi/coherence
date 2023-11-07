<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable 
{
    use HasApiTokens, HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'matricule',
        'poste',
        'tel',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function logoutOtherDevices($password)
    {
        if (Hash::check($password, $this->password)) {
            $this->tokens->each(function ($token, $key) {
                if ($key !== $this->currentAccessToken()->id) {
                    $token->delete();
                }
            });
        }
    }

}
