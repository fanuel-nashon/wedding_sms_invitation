<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'sms_token',
        'sms_username',
        'sms_password',
        'sms_sender_id',
        'sms_url',
        'sms_delivery_token',
    ];

    protected $casts = [
        'sms_token' => 'encrypted',
        'sms_password' => 'encrypted',
        'sms_delivery_token' => 'encrypted',
    ];
}
