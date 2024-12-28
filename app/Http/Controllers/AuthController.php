<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request)
    {
        //validation 
        $validation = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        //attempt login
        if (!auth()->attempt($validation)) {
            return response()->json([
                'message' => 'Invalid login credentials',
            ], 401);
        }

        //return response
        return response()->json([
            'message' => 'Login successful',
            'user' => auth()->user(),
            'token' => auth()->user()->createToken('authToken')->plainTextToken,
            'role' => auth()->user()->getRoleNames()->first(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        // validation
        $validation = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        // creat user
        $user = User::create([
            'name' => $validation['name'],
            'email' => $validation['email'],
            'password' => bcrypt($validation['password']),
        ]);

        // assign role
        $user->assignrole('customer');

        //return response
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function logout(Request $request)
    {
        //revoke token
        $request->user()->currentAccessToken()->delete();

        // return response
        return response()->json([
            'message' => 'Logout successful',
        ]);
    }

}
