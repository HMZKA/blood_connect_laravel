<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctors = Doctor::all();
        return response()->json(["doctors" => $doctors]);
    }



    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "image" => "required|image",
        ]);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()]);
        }
        $image = time() . '_' . uniqid() . '.' . $request->image->extension();
        $request->image->move(public_path('storage/doctors'), $image);
        $doctor = Doctor::create(["name" => $request->name, "image" => "/storage/doctors/$image"]);
        return response()->json(["message" => "Created successfully", "data" => $doctor]);
    }
}
