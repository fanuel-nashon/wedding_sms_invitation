<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contributor extends Model
{
    protected $table = 'contributors';

    protected $fillable = [
        'name',
        'phone_no',
        'assigned_seats',
        'status',
        'qr_code',
        'text_code'
    ];
}
