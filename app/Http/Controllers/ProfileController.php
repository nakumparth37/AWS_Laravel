<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
;

class ProfileController extends Controller
{

    public function show()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function showProfileSetting()
    {
        $user = Auth::user();
        return view('profile.profileSetting', compact('user'));
    }

    public function saveProfileChange(Request $request)
    {
        $userID = Auth::user()->id;
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userID,
            'phone_number' => 'required|numeric',
            'profileImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'addressLine1' => 'required|string|max:255',
            'addressLine2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'pinCode' => 'required|numeric',
        ]);

        $user = User::findOrFail($userID);

        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->addressLine1 = $request->addressLine1;
        $user->addressLine2 = $request->addressLine2;
        $user->city = $request->city;
        $user->country = $request->country;
        $user->state = $request->state;
        $user->pinCode = $request->pinCode;
        // dd($user);
        if ($request->hasFile('profileImage')) {
            if ($user->profileImage) {
                $user->deleteUserProfileImg();
            }
            $user->profileImage = $user->saveUserProfileImg($request->file('profileImage'));

        }
        $user->save($request->except(['profileImage']));
        return redirect()->back()->with('success', 'Profile updated successfully.');

    }
}
