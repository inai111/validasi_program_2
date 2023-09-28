<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Reports extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'subject','target_id','file_id','status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model){
            $model->slug = Uuid::uuid1();
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function files()
    {
        return $this->hasMany(Files::class,'report_id');
    }

    public function target()
    {
        return $this->belongsTo(User::class,'target_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
