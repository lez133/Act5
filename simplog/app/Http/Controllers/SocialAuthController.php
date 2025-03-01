<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    // Redirect to Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle Google Callback
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            return $this->findOrCreateUser($googleUser, 'google');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Failed to login with Google.');
        }
    }

    // Redirect to Facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Handle Facebook Callback
    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->stateless()->user();
            return $this->findOrCreateUser($facebookUser, 'facebook');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Failed to login with Facebook.');
        }
    }

    // Find or create user
    private function findOrCreateUser($providerUser, $provider)
    {
        // Ensure email exists (Some Facebook accounts may not have an email)
        $email = $providerUser->getEmail() ?? $providerUser->getId() . "@$provider.com";

        $user = User::where('provider', $provider)
                    ->where('provider_id', $providerUser->getId())
                    ->orWhere('email', $email)
                    ->first();

        if (!$user) {
            $user = User::create([
                'name' => $providerUser->getName(),
                'username' => explode('@', $email)[0], // Generate username from email
                'email' => $email,
                'provider' => $provider,
                'provider_id' => $providerUser->getId(),
                'password' => bcrypt(Str::random(16)), // Generate a secure random password
            ]);
        }

        Auth::login($user);
        return redirect('/dashboard')->with('success', 'Successfully logged in!');
    }

    // Logout function
    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'You have been logged out.');
    }
}
