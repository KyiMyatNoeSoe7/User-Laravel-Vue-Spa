<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
class AuthController extends Controller
{   
    public function index(Request $request)
    {   
        return User::where('email', trim($request->email))->first();
    }
    /**
     * Create a new user instance
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function register(Request $request)
    {
        $user = User::create([

            'name' => $request['name'],
            'password' => Hash::make($request['password']),
            'email' => $request['email'],
            'role_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        return $user;
    }
    /**
     * Create a new controller to login this system.
     *
     * @return void
     */
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
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {   
        $cookie = Cookie::forget('jwt');

        return response([
            'message' => 'Success logout'
        ])->withCookie($cookie);
    }
    /**
     * Create a new user profile controller.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function profile(Request $request) 
    {
        return User::where('email', trim($request->email))->first();
    }
}

