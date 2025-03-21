<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;



class AuthController extends Controller
{
   
    public function register(Request $request){
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|string|min:8|confirmed',

        ]);
        if ($request->fails()) {
            return response()->json([
                'errors' => $request->errors(),
            ], 422);
        }
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        return response()->json(['user'=>$user],201);
    }
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json(['token' => $token, 'user' => $user]);
}
    public function logout(Request $request){
        $request->user()->Token()->delete();
    }


}


