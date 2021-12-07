<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;


class UserController extends Controller
{   
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return $users;      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userData = User::find($id);
        return response()->json($userData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, UserUpdateRequest $request)
    {   
        $user = User::find($id);
        $user->update($request->all());

        return $user;
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json('User deleted!');
    }
    public function showUser(Request $request)
    {   
        $users = User::query();
        if($request->keyword) {
            return $users->where('name', 'like', "%" . $request->keyword . "%")
           ->paginate(5);
        } else {
            return $users->all()->get()->paginate(5);
        }

    }
}
