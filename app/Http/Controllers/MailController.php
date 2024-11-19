<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class MailController extends Controller
{
    public function sendPasswordResetEmail(Request $request)
    {
        try {
            $userData = request()->post();
            $name = $userData['name'];
            $email = $userData['email'];
            $otp = random_int(100000, 999999);
            $mailData = [
                "subject" => "Email Verification OTP",
                "name" => $name,
                "OTP" => $otp
            ];
            Mail::to($user->email)->send(new PasswordReset($mailData,'reset_password'));
            
        } catch (\Throwable $th) {
            //throw $th;
        }

    }
}
