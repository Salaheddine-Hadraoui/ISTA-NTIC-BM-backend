<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthSocialiteController  extends Controller
{
    public function redirectToSOcilaProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function callbackToSocialProvider($provider)
    {
        try {
            $SocialUser = Socialite::driver($provider)->user();
            if (!$SocialUser->getEmail()) {
                return response()->json([
                    ['error' => 'No email found from' . $provider], 400
                ]);
            }

            $user = User::where('email', $SocialUser->getEmail())
                ->orWhere('client_id', $SocialUser->getId())->first();
                if (!$user) {
                    $user = User::create([
                        'email'=>$SocialUser->getEmail(),
                        'name' => $SocialUser->getName(),
                        'password' => Hash::make(uniqid()),
                        'client_id' => $SocialUser->getId(),
                        'client_provider' => $provider,
                        'client_avatar' => $SocialUser->getAvatar(),
                        'role' => 'user'
                    ]);
            } else {
                $user->update([
                    'client_provider' => $provider,
                    'client_id' => $SocialUser->getId(),
                    'client_avatar' => $SocialUser->getAvatar(),
                ]);
            }
            $user = $user->fresh();
            Auth::login($user, true);
            return redirect(env('FRONTEND_URL') . '/entrer/join-us?log-in=true');
        } catch (Exception $e) {
            return redirect(env('FRONTEND_URL') . '/entrer/join-us?log-in=failed');
         }
    }
   
}
