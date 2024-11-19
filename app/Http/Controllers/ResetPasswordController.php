<?php

namespace App\Http\Controllers;

use App\Models\Email_otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\SendEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{

    public function showVerifyOTP()
    {
        return view('auth.verifyOTP');
    }

    public function showResetPassword()
    {
        return view('auth.reset_password');
    }


    public function sendOTPEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:250',
        ]);

        try {
            $userData = User::where('email', $request->email)->first();
            if ($userData) {
                $name = $userData->name;
                $email = $request->email;
                $otp = random_int(100000, 999999);
                $mailData = [
                    "subject" => "Email Verification OTP",
                    "name" => $name,
                    "OTP" => $otp
                ];

                if (Mail::to($email)->send(new SendEmail($mailData,'reset_password'))) {
                    Email_otp::create([
                        'EmailOTP' => $otp,
                        'email' => $email
                    ]);
                    session::put('otp_email',$request->email);
                    // notify()->success("Email hes been send on $request->email");
                    return redirect()->route('showVerifyOTP')->onlyInput('email')->with('success',"Email hes been send on $request->email");
                }
            }

            // notify()->error("$request->email does not exist.");
            return back()->onlyInput('email')->with('error',"$request->email does not exist.");

        } catch (\Exception $th) {
            // notify()->error($th->getMessage());
            return redirect()->back()->with('error',$th->getMessage());
        }

    }


    public function verifyEmailOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:250,email',
            'emailOTP' => 'required|numeric|digits:6',
        ]);

        $getOTP = Email_otp::where('email', $request->email)->latest()->first();
        $otpDate = Carbon::parse($getOTP->created_at);
        $userData = User::where('email',$request->email)->first();
        $currentTime = Carbon::now();
        if ($getOTP && $getOTP->EmailOTP == $request->emailOTP) {
            $getOTP->delete();
            session::put('otp_email',$request->email);
            if ($userData->is_email_verified == true) {
                // notify()->success("Email verified successfully");
                return redirect()->route('showResetPassword')->onlyInput('email')->with('success','Email verified successfully');
            }else{
                $userData->is_email_verified = true;
                $userData->save();
                // notify()->success("Email verified successfully");
                return redirect()->route('login')->with('success','Email verified successfully');
            }
        }else if($getOTP && $otpDate->diffInMinutes($currentTime) > 10){
            // notify()->error("OTP has been expired");
            return back()->onlyInput('email')->with('error','OTP has been expired');
        }else{
            // notify()->error("Invalid OTP !");
            return back()->onlyInput('email')->with('error','Invalid OTP !');
        }

    }


    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $userData = User::where('email', $request->email)->first();
        if ($userData) {
            $userData->password = Hash::make($request->password);
            $userData->save();
            session::forget('otp_email');
            return redirect()->route('login')->with('success','Your password has been updated login with new password');
        }else{
            return  redirect()->back()->with('User is not registered');
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $userData = User::where('email', Auth::user()->email)->first();
        if ($userData) {
            $userData->password = Hash::make($request->password);
            $userData->save();
            return  redirect()->back()->with('success','Your password has been saved');
        }else{
            return  redirect()->back()->with('error','Something want wrong try agin letter');
        }
    }
}
