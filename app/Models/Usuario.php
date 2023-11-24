<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'email',
        'password',
        'perfil_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function getCreatedAtAttribute($value)
    {
        $data = date_create($value);
        return $data->format('d/m/Y H:i:s');
    }
 
    public function getUpdatedAtAttribute($value)
    {
        $data = date_create($value);
        return $data->format('d/m/Y H:i:s');
    }

    public function perfil()
    {
        return $this->belongsTo('App\Models\Perfil', 'perfil_id', 'id');
    }
}
