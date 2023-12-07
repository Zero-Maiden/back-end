<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotel = Hotel::all();
        // If hotel exists, read hotel
        // Else hotel not found
        if($hotel->count() > 0) {
            return response()->json([
                'status'  => 200,
                'message' => $hotel
            ], 200);
        } else {
            return response()->json([
                'status'  => 404,
                'message' => 'Hotel not found!'
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:32',
            'location' => 'required|string|max:32',
            'room' => 'required|string|max:32',
            'price' => 'required|string|max:32'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else {
            $hotel = Hotel::create([
                'name' => $request->name,
                'location' => $request->location,
                'room' => $request->room,
                'price' => $request->price,
                'status' => false
            ]);

            if($hotel) {
                return response()->json([
                    'status' => 200,
                    'message' => "Hotel added!"
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => "Something went wrong!"
                ], 500);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Hotel $id)
    {
        $hotel = Hotel::find($id);
        // If hotel exists, read hotel
        // Else hotel not found
        if($hotel) {
            return response()->json([
                'status'  => 200,
                'message' => $hotel
            ], 200);
        } else {
            return response()->json([
                'status'  => 404,
                'message' => 'User not found!'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:32',
            'location' => 'required|string|max:32',
            'room' => 'required|string|max:32',
            'price' => 'required|string|max:32'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else {
            $hotel = Hotel::find($id);
            if($hotel) {
                $hotel->update([
                    'name' => $request->name,
                    'location' => $request->location,
                    'room' => $request->room,
                    'price' => $request->price,
                    'status' => false
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Hotel updated!"
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => "Hotel not found!"
                ], 404);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $hotel = Hotel::find($id);
        if($hotel) {
            $hotel->delete();
            return response()->json([
                'status' => 200,
                'message' => "Hotel berhasil dihapus!"
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "Hotel tidak ditemukan!"
            ], 404);
        }
    }
}
