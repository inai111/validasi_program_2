<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reports extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'subject','target_id','file_id','status'
    ];

    public function files()
    {
        return $this->hasMany(Files::class,'report_id');
    }
}
