<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\Email_otp;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Str;


class LoginRegisterController extends Controller
{

    public function register()
    {
        return view('auth.register');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'surname' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'phone_number' => 'required|numeric|digits:10',
            'role_type' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
        $userRoll = Role::where('role_type', $request->role_type)->firstOrFail();

        User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'role_id' => $userRoll->id,
            'password' => Hash::make($request->password)
        ]);

        $credentials = $request->only('email', 'password');
        try {
            $userData = User::where('email', $request->email)->first();
            $name = $userData->name;
            $email = $request->email;
            $otp = random_int(100000, 999999);
            $mailData = [
                "subject" => "Email Verification OTP",
                "name" => $name,
                "OTP" => $otp
            ];
            if (Mail::to($email)->send(new SendEmail($mailData,'email_verify_otp'))) {
                Email_otp::create([
                    'EmailOTP' => $otp,
                    'email' => $email
                ]);
                session::put('otp_email',$request->email);
                return redirect()->route('showVerifyOTP')->onlyInput('email')->with('success',"Email hes been send on $request->email ,Please verify you email and Login");
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error',$th->getMessage());
        }
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $remember = $request->has('remember');

        if(Auth::attempt($credentials,$remember))
        {
            $userRole = $request->user()->role_id;
            if ($userRole === 1) {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard')->with([
                    'success' => "Welcome Back " . $request->user()->name . " !"
                ]);
            } elseif ($userRole === 2) {
                $request->session()->regenerate();
                return redirect()->route('seller.dashboard')->with([
                    'success' => "Welcome Back " . $request->user()->name . " !"
                ]);
            } elseif ($userRole === 3) {
                $request->session()->regenerate();
                return redirect()->route('dashboard')->with([
                    'success' => "Welcome Back " . $request->user()->name . " !"
                ]);
            }
        }
        return back()->onlyInput('email','password')->with('error','Your provided credentials do not match in our records.');

    }

    public function adminDashboard()
    {
        if(Auth::check())
        {
            $userRole = auth()->user()->role_id;
            if ($userRole === 1) {
                return view('admin.dashboard');
            }
        }
        return redirect()->route('login')->onlyInput('email')->with('error','Please login to access the dashboard.');
    }

    public function sellerDashboard()
    {
        if (Auth::check())
        {
            $userRole = auth()->user()->role_id;
            if ($userRole === 2) {
                return view('seller.dashboard');
            }
        }
        return redirect()->route('login')->onlyInput('email')->with('error','Please login to access the dashboard.');
    }

    public function dashboard()
    {
        if (Auth::check())
        {
            $userRole = auth()->user()->role_id;
            if ($userRole <= 3) {
                return view('auth.dashboard');
            }
        }
        return redirect()->route('login')->onlyInput('email')->with('error','Please login to access the dashboard.');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $user = $request->user();
        return redirect()->route('login')->with('success','You have successfully logged Out');
    }

    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGithubCallback()
    {
        $githubUser = Socialite::driver('github')->user();
        $findUser = User::where('email', $githubUser->getEmail())->first();
        if($findUser){
            Auth::login($findUser);
            return redirect()->intended('dashboard');
        }else{
            $user = User::updateOrCreate([
                'email' => $githubUser->getEmail(),
            ], [
                'name' => $githubUser->name,
                'provider_id' => $githubUser->getId(),
                'profileImage' => $githubUser->avatar,
                'password' => Hash::make('Password'),
                'token' => $githubUser->token,
            ]);
        }
        Auth::login($user);

        return redirect('/dashboard')->with('success','You are login successfully and you password is "Password"');

    }


    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {

            $googleUser = Socialite::driver('google')->user();
            $findUser = User::where('email', $googleUser->email)->first();


            if($findUser){
                Auth::login($findUser);
                return redirect()->intended('dashboard');
            }else{
                $newUser = User::updateOrCreate([
                    'email' => $googleUser->email
                ],[
                    'name' => $googleUser->name,
                    'token' => $googleUser->token,
                    'profileImage' => $googleUser->avatar,
                    'password' => Hash::make('Password'),
                ]);
                Auth::login($newUser);
                return redirect()->intended('dashboard')->with('success','You are login successfully and you password is "Password"');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
