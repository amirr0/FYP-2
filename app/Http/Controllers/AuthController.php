<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserBasicInformation;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{

    public function showLoginForm()
    {
        // dd(Hash::make(123));
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->status == "Inactive") {
                Auth::logout();
                return back()->withInput()->withErrors(['email' => 'Your account is inactive. Please contact support.']);
            }

            if ($user->role->name == 'Client') {
                return redirect()->route('services.index');
            }
            return redirect()->route('backend.dashboard');
        }

        return back()->withInput()->withErrors(['email' => 'Invalid email or password']);
    }



    public function showregisterForm()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $request->validate([

            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate profile picture
        ]);

        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicture = $request->file('profile_picture');
            $profilePicturePath = $profilePicture->store('profile_pictures', 'public');
        }


        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 3,
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'profile_picture' => $profilePicturePath,
        ]);

        Auth::login($user);


        return redirect()->route('services.index');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logout successfully');
    }

    public function showForgetForm()
    {
        return view('auth.forgot-password');
    }

    public function forgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        if (Password::sendResetLink(
            $request->only('email')
        )) {
            return back()->with('success', 'Password reset link sent! Please check your email.');
        } else {
            return back()->withErrors(['error' => 'Unable to send password reset link. Please try again later.']);
        }
    }

    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        } else {
            return redirect()->back()->withErrors(['email' => __($status)]);
        }
    }
}
