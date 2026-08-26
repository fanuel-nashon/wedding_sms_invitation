<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\LoggerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validateWithBag('updatePassword', [
                'current_password' => ['required', 'current_password'],
                'password' => ['required', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            if ($e->validator->errors()->has('current_password')) {
                LoggerService::log('Password', $request->user()->email, $request->user()->name, 'Failed password change attempt: incorrect current password');
            }

            throw $e;
        }

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        LoggerService::log('Password', $request->user()->email, $request->user()->name, 'Changed password successfully');

        return back()->with('status', 'password-updated');
    }
}
