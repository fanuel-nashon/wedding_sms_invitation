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
            Habari! 🎉
            Familia ya Nashon Fanuel Rhobi inayo furaha kukualika
                {$name}

            Kwenye Sherehe ya Mapokezi (Reception) ya kijana wao mpendwa
                David Sanawa Nashon
            Itakayofanyika tarehe 30 Agosti 2026 kuanzia saa 12:00 jioni, kwenye ukumbi wa Destiny Hall - Kwa Mathias, Kibaha-Pwani

                Code ya kadi yako ni: {$codeDisplay}
            Tafadhali taja/onesha kadi mara tu ufikapo ukumbini

            Kwa mawasiliano Zaidi (RSVP)

            0654479492
            0790511519

            Location: https://maps.app.goo.gl/i3btKsTKcEbkuFnd6
            TEXT;
    }

    public function smsPreview(Contributor $contributor)
    {
        return response()->json([
            'message' => $this->smsCreator($contributor),
        ]);
    }

    public function sendSms(Contributor $contributor)
    {
        $message = $this->smsCreator($contributor);

        $service = new SmsService();
        $response = $service->sendSms($contributor->phone_no, $message);

        if(!$response || !$response->successful()) {
            return back()->with('failure', 'failure to send SMS invitation');
        }

        LoggerService::log('SMS', auth()->user()->email, auth()->user()->name, 'Sent invitation SMS to: ' . $contributor->name);

        return back()->with('success', 'Invitation SMS sent to ' . $contributor->name);
    }
}
