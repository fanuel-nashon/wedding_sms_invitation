<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';

    protected $fillable = [
        'module',
        'user_email',
        'user_name',
        'action',
        'action_time'
    ];

    protected $casts = [
        'action_time' => 'datetime',
    ];
}
