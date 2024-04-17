<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    use HasFactory;


    public $timestamps = false;
    const CREATED_AT = true;

    protected $fillable = [
        'user',
        'action',
        'description',
        'ip'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s'
    ];
}
