<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
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
    public function register(){
        
    }
    public function logout(){
        if (Auth::check()) {
            Auth::logout();
    
            return response()->json([
                'message' => 'Déconnexion réussie.',
            ], 200);
        }

        return response()->json([
            'message' => 'Aucun utilisateur connecté.',
        ], 401);
    }
}
