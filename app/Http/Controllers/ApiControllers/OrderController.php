<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "blood_type" => "required",
            "image" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()], 400);
        }
        $image = explode("base64,", $request->image);
        $image = end($image);
        $image = str_replace(' ', '+', $image);
        $orderImage = time() . '_' . uniqid() . '.jpg';
        $disk = Storage::build([
            'driver' => 'local',
            'root' => public_path() . "/storage/orders",
            "url" => env('APP_URL') . "/storage"
        ]);
        $disk->put($orderImage, base64_decode($image));
        

        $order =   Order::create([
            "blood_type" => $request->blood_type,
            "image_url" => "/storage/orders/". $orderImage,
            "user_id" => $request->user()->id,
        ]);
        $user = User::find($request->user()->id);
        $user->order_count = $user->order_count + 1;
        $user->save();
        return response()->json(["message" => "Order sent successfully", "image" => $order], 200);
    }
}
