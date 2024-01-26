<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            "phone" => ["required"],
            "password" => ["required"],
        ]);
        if (Auth::attempt($credentials)) {
            $user = $request->user();

            $token =  $user->createToken("API TOKEN");

            return response()->json(["data" => $user, "token" => $token->plainTextToken]);
        }
        return response(["message" => "Invalid credentials"], 401);
    }





    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "first_name" => "required",
            "last_name" => "required",
            "password" => "required",
            "phone" => "required|unique:users",
            "identity_number" => "required|unique:users"
        ],);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 400);
        }

        $user =  User::create([
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "password" => Hash::make($request->password),
            "phone" => $request->phone,
            "identity_number" => $request->identity_number,
            "donation_count" => 0,
            "order_count" => 0
        ]);


        $token =  $user->createToken("API TOKEN");
        return response()->json(["message" => "Created successfully", "data" => $user, "token" => $token->plainTextToken], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(["message" => "Logout Successfully"], 200);
    }
}
