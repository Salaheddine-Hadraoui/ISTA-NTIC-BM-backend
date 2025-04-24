<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 🔐 Login
    public function login(LoginRequest $request)
    {
        $user = $request->validated();
        if (!Auth::attempt($user)) {
            return response()->json([
                'message' => "email n'a pas été trouvé, inscrivez-vous"
            ], 401);
        }
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie.',
            'user'    => $user,
            'role' => $user->role,
            'token'   => $token,
        ]);
    }

    // 📝 Register
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $user=$user->fresh();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Inscription réussie.',
            'user'    => $user,
            'token'   => $token,
        ], 201);
    }

    
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie.'
        ]);
    }
}

