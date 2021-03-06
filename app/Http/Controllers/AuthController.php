<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{   
    public function index()
    {   
        return Auth::user();
    }
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'password' => Hash::make($request['password']),
            'email' => $request['email']
        ]);
        $user->save();
        return $user;
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request['email'])->first();

        if(!$user || !Hash::check($request['password'], $user->password)){
            return response([
                'message' => 'Not match'],401);
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        $cookie = cookie('jwt', $token, 60*24);

        return response([
            'message' => $token
        ])->withCookie($cookie);
    }

    public function logout()
    {   
        $cookie = Cookie::forget('jwt');

        return response([
            'message' => 'Success logout'
        ])->withCookie($cookie);
    }

    public function profile(Request $request) 
    {
        return User::where('email', trim($request->email))->first();
    }
}

