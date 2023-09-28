<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Files extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    protected $fillable = [
        'file_path','description'
    ];

    public function report()
    {
        return $this->belongsTo(Reports::class);
    }
}
