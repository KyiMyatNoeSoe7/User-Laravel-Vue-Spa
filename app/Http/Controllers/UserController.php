<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return $users;      
    }

    public function store(Request $request)
    {   
        
        
    }

    public function show($id)
    {
        $userData = User::find($id);
        return response()->json($userData);
    }

    public function update($id, UserUpdateRequest $request)
    {   
        $user = User::find($id);
        $user->update($request->all());

        return $user;
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json('User deleted!');
    }
}
