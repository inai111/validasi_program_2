<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin()
    {
        return $this->roles->contains('name_code','admin');
    }

    public function roles()
    {
        return $this->belongsToMany(Roles::class,'user_role','user_id','role_id');
    }

    public function sent_reports()
    {
        return $this->hasMany(Reports::class)->orderByRaw("
        CASE
            WHEN status = 'progress' THEN 1
            WHEN status = 'approved' THEN 2
            WHEN status = 'rejected' THEN 3
            WHEN status = 'canceled' THEN 4
            ELSE 5
        END
        ")->orderBy('updated_at', 'desc');
    }

    public function incoming_reports()
    {
        return $this->hasMany(Reports::class,'target_id')->whereNot('status','canceled')->orderByRaw("
        CASE
            WHEN status = 'progress' THEN 1
            WHEN status = 'approved' THEN 2
            WHEN status = 'rejected' THEN 3
            WHEN status = 'canceled' THEN 4
            ELSE 5
        END
        ")->orderBy('updated_at', 'desc');
    }

    
}
