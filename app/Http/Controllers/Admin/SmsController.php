<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contributor;
use App\Services\LoggerService;
use App\Services\SmsService;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function smsCreator(Contributor $contributor): string
    {
        $code = $contributor->ensureInvitationCode();
        $name = mb_strtoupper($contributor->name);
        $seats = $contributor->assigned_seats;
        $seatLabel = match ($seats) {
            1 => 'Single',
            2 => 'Double',
            default => "Viti {$seats}",
        };
        $codeDisplay = "{$code} - {$seatLabel}";

        return <<<TEXT
            {$name}, Salaam🎉
            Familia ya Nashon Fanuel Rhobi inayo furaha kukualika kwenye Sherehe ya harusi ya kijana wao mpendwa David Sanawa Nashon itakayofanyika Jumapili hii tarehe 30 Agosti 2026 kuanzia saa 12:00 jioni, kwenye ukumbi wa Destiny Hall - Kwa Mathias, Kibaha-Pwani

            Code ya kadi yako ni: {$codeDisplay}
            Tafadhali taja/onesha kadi mara tu ufikapo ukumbini

            Kwa mawasiliano Zaidi (RSVP)
            0654479492
            0723827440

            Location: https://www.google.com/maps/search/?api=1&query=-6.7587189,38.9339044
            TEXT;
    }

    public function smsPreview(Contributor $contributor)
    {
        return response()->json([
            'message' => $this->smsCreator($contributor),
        ]);
    }

    private function recordSendResult(Contributor $contributor, ?\Illuminate\Http\Client\Response $response): bool
    {
        if (!$response || !$response->successful()) {
            return false;
        }

        $body = $response->json();

        $contributor->sms_message_id = data_get($body, 'messageId')
            ?? data_get($body, '0.messageId')
            ?? data_get($body, 'messages.0.messageId')
            ?? data_get($body, 'results.0.messageId')
            ?? data_get($body, 'data.messageId');
        $contributor->sms_delivery_status = 'PENDING';
        $contributor->sms_delivery_updated_at = now();
        $contributor->save();

        return true;
    }

    public function sendSms(Contributor $contributor)
    {
        $message = $this->smsCreator($contributor);

        $service = new SmsService();
        $response = $service->sendSms($contributor->phone_no, $message);

        if (!$this->recordSendResult($contributor, $response)) {
            return back()->with('failure', 'failure to send SMS invitation');
        }

        $contributor->sms_resent_at = null;
        $contributor->save();

        LoggerService::log('SMS', auth()->user()->email, auth()->user()->name, 'Sent invitation SMS to: ' . $contributor->name);

        return back()->with('success', 'Invitation SMS sent to ' . $contributor->name);
    }

    public function resendUndelivered(Contributor $contributor)
    {
        if ($contributor->sms_resent_at) {
            return back()->with('failure', 'Already resent once to ' . $contributor->name . '. Contact the guest directly if it still has not arrived.');
        }

        $message = $this->smsCreator($contributor);

        $service = new SmsService();
        $response = $service->sendSms($contributor->phone_no, $message);

        if (!$this->recordSendResult($contributor, $response)) {
            return back()->with('failure', 'failure to resend SMS invitation');
        }

        $contributor->sms_resent_at = now();
        $contributor->save();

        LoggerService::log('SMS', auth()->user()->email, auth()->user()->name, 'Resent invitation SMS to: ' . $contributor->name);

        return back()->with('success', 'Invitation SMS resent to ' . $contributor->name);
    }

    public function deliveryStatus(Contributor $contributor)
    {
        return response()->json([
            'status' => $contributor->sms_delivery_status,
            'messageId' => $contributor->sms_message_id,
            'updatedAt' => $contributor->sms_delivery_updated_at?->diffForHumans(),
        ]);
    }
}
