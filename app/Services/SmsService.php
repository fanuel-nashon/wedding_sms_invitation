<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    private string $token;
    private string $from;
    private string $url;


    const SEND_SMS_URL = 'api/sms/v2/text/single';

    public function __construct()
    {
        $settings = Setting::first();

        $this->token = $settings?->sms_token ?? '';
        $this->from = $settings?->sms_sender_id ?? '';
        $this->url = $settings?->sms_url ?? '';
    }

    public function sendSms(string $to, string $text): ?\Illuminate\Http\Client\Response
    {
        $endpoint = rtrim($this->url, '/') . '/' . self::SEND_SMS_URL;

        try {
            $response = Http::withToken($this->token)
                ->acceptJson()
                ->post($endpoint, [
                    'from' => $this->from,
                    'to' => $to,
                    'text' => $text,
                    'flash' => 0,
                    'reference' => (string) str()->uuid(),
                ]);

            if (! $response->successful()) {
                Log::error('SMS API returned an error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'to' => $to,
                ]);
            } else {
                Log::info('SMS API response', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'to' => $to,
                ]);
            }

            return $response;
        } catch (\Exception $e) {
            Log::error('SMS sending error', [
                'message' => $e->getMessage(),
                'to' => $to,
            ]);

            return null;
        }
    }
}
