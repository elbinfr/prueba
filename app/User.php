<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeSearch($query, $parameters)
    {
        $query->select('name', 'email', 'avatar');

        foreach ($parameters as $key => $value) {
            if ($key == 'id') {
                $query->whereRaw('lower(' . $key . ') = ?', [strtolower($value)]);
            } else {
                $query->whereRaw('lower(' . $key . ') like ?', ['%'.strtolower($value).'%']);
            }            
        }

        return $query;
    }
}
