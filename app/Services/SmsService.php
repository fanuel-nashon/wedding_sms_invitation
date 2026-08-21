<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    private string $token;
    private string $url;
    private string $from;
    private array $headers;

    const SEND_SMS_URL = 'api/sms/v2/text/single';

    public function __construct()
    {
        $settings = Setting::pluck('value', 'key');

        $this->token = $settings['sms_token'];

        $this->from = $settings['sms_username'];

        $this->url = $settings['sms_url'];

        $this->headers = [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }
    public function sendSms($to, $text){
        $endpoint = rtrim($this->url, '/') . '/' . self::SEND_SMS_URL;

        try{
            $response = Http::withHeaders($this->headers)
                ->post($endpoint, [
                    'from' => $this->from,
                    'to' => $to,
                    'text' => $text,
                    'flash' => 0,
                    'reference' => 'invitation'
                ]);

            if($response->successful()){
                return $response;
            }

            Log::error('SMS Api returned an error', [
                'status' => $response->status(),
                'body' => $response->body(),
                'to' => $to
            ]);

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
