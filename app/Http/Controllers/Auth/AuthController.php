<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function Login(LoginRequest $request){
        $data = $request->validated();
        
        if(!Auth::attempt($data)){
            return response()->json([
               'message' => 'Email ou mot de passe invalide.'
            ], 401);
        }
        $user = Auth::user();
        return response()->json([
            'message' => 'Connexion réussie.',
            'user' => $user,
        ]);
    }
    public function Register(RegisterRequest $request){
        $data = $request->validated();

        if($data){
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
            $user = $user->fresh();
            Auth::login($user);
        
            return response()->json([
                'message' => 'Inscription réussie.',
                'user' => $user,
            ]);
        };
        return response()->json([
            'message' => 'Inscription réussie.',
        ],401);
    }
    public function logout(Request $request){
        try{
            if (Auth::check()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
        
                return response()->json([
                    'message' => 'Déconnexion réussie.',
                    'user' => Auth::user()
                ], 200);
            }
    
            return response()->json([
                'message' => 'Aucun utilisateur connecté.',
            ], 401);
        }
        catch(Exception $e){
            return response()->json([
                'message' => 'error'
            ], );
        }
    }
}
