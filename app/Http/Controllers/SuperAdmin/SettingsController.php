<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\LoggerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::firstOrCreate([], [
            'sms_token' => '',
            'sms_username' => '',
            'sms_password' => '',
            'sms_sender_id' => '',
        ]);

        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'sms_username' => 'required|string',
            'sms_sender_id' => 'required|string',
            'sms_token' => 'nullable|string',
            'sms_password' => 'nullable|string',
        ]);

        $settings = Setting::firstOrCreate([], [
            'sms_token' => '',
            'sms_username' => '',
            'sms_password' => '',
            'sms_sender_id' => '',
        ]);

        try {
            $settings->sms_username = $request->sms_username;
            $settings->sms_sender_id = $request->sms_sender_id;

            if ($request->filled('sms_token')) {
                $settings->sms_token = $request->sms_token;
            }

            if ($request->filled('sms_password')) {
                $settings->sms_password = $request->sms_password;
            }

            $settings->save();

            LoggerService::log('Settings', auth()->user()->email, auth()->user()->name, 'Updated SMS gateway settings');

            return back()->with('success', 'Settings updated successfully');
        } catch (\Exception $e) {
            Log::alert('Failed to update settings: ' . $e->getMessage());
            return back()->with('failure', 'Something went wrong, please try again later');
        }
    }
}
