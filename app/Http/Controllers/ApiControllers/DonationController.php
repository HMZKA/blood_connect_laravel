<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class DonationController extends Controller
{
    public function create(Request $request)
    {


        $validator = Validator::make($request->all(), [
            "age" => "required",
            "weight" => "required",
            "blood_type" => "required",
            "last_time" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()], 400);
        }
        Donation::create([
            "age" => $request->age,
            "weight" => $request->weight,
            "blood_type" => $request->blood_type,
            "last_time" => $request->last_time,
            "user_id" => $request->user()->id,
        ]);
        $user = User::find($request->user()->id);
        $user->donation_count = $user->donation_count + 1;
        $user->save();
        return response()->json(["message" => "Thanks for your Donation"], 200);
    }
}
