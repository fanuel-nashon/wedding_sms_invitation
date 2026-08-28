<?php

namespace App\Http\Controllers;

use App\Models\Contributor;
use App\Models\Setting;
use Illuminate\Http\Request;

class SmsDeliveryWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $settings = Setting::first();

        if (!$settings || !$settings->sms_delivery_token || $request->input('token') !== $settings->sms_delivery_token) {
            return response()->json(['message' => 'Invalid token'], 403);
        }

        $messageId = $request->input('messageId');

        $contributor = Contributor::withTrashed()->where('sms_message_id', $messageId)->first();

        if ($contributor) {
            $contributor->sms_delivery_status = $request->input('status');
            $contributor->sms_delivery_updated_at = now();
            $contributor->save();
        }

        return response()->json(['message' => 'ok']);
    }
}
