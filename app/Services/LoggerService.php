<?php

namespace App\Services;

use App\Models\Log;

class LoggerService
{
    public static function log(string $module, string $userEmail, string $userName, string $action):void
    {
        Log::create([
            'module'=>$module,
            'user_email'=>$userEmail,
            'user_name'=>$userName,
            'action'=>$action,
            'action_time'=>now(),
        ]);
    }
}