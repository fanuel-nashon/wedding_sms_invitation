<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function sendSms(Request $request){
        $request->validate([
            
        ]);
    }
}
