<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @return [string] message
     * @return [string] access_token
     * @return [string] token_type
     */

    public function register(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:30',
            'email' => 'required|string|email|max:30|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|numeric|max:2'
        ]);

        /**
         * 0 = Owner get 0 credit
         * 1 = Premium get 40 credit
         * 2 = Regular get 20 credit
        */
        $credit = null;
        $role = $validatedData['role'];
        switch ($role) {
            case 1:
                $credit = 40;
                break;
            case 2:
                $credit = 20;
                break;
            default:
                $credit = 0;
        }

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
            'credit' => $credit
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Register success',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @return [string] access_token
     * @return [string] token_type
     * @return [object] data
     */

    public function login(Request $request) {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Login failed'],
                401
            );
        }
        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'data' => $user
        ]);
    }

     /**
     * Logout User
     *
     * @return [string] message
     */

    public function logout(){
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout success'
        ]);
    }
}
