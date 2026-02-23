<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasswordResetRequest;
use App\Models\User;

class PasswordResetRequestController extends Controller
{

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = \App\Models\User::where('email', $request->email)->first();

        \App\Models\PasswordResetRequest::create([
            'user_id' => $user ? $user->id : null,
            'email' => $request->email,
            'status' => 'pending',
        ]);

        return view('auth.passwords.confirm');
    }
}
