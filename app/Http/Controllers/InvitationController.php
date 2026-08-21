<?php

namespace App\Http\Controllers;

use App\Models\Contributor;
use App\Services\LoggerService;

class InvitationController extends Controller
{
    public function show(string $code)
    {
        $contributor = Contributor::where('text_code', $code)->firstOrFail();

        return view('invitations.show', ['contributor' => $contributor]);
    }

    public function verify(string $code)
    {
        $contributor = Contributor::where('text_code', $code)->firstOrFail();

        return view('invitations.verify', ['contributor' => $contributor]);
    }

    public function confirm(string $code)
    {
        $contributor = Contributor::where('text_code', $code)->firstOrFail();

        if ($contributor->status !== 'attended') {
            $contributor->status = 'attended';
            $contributor->save();

            LoggerService::log('Verification', auth()->user()->email, auth()->user()->name, 'Confirmed attendance: ' . $contributor->name);
        }

        return redirect()->route('invitations.verify', $code)->with('success', 'Attendance confirmed for ' . $contributor->name);
    }
}
