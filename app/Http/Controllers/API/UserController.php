<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * Login authentication
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'status' => 200,
                'token' => $token,
                'message' => 'Login successful',
            ], 200);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Invalid credentials',
            ], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        // Required field
        // Checks if all fields are filled or not
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|min:4|max:255',
            'email'    => 'required|string|min:4|max:190',
            'password' => 'required|string|min:4|max:60'
        ]);
        // If all fields does not meet the minimum requirements, send an error messages, else create new user
        if($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => $validator->messages()
            ], 422);
        } else {
            $user = new User([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $user->save();
            // If user is succesfully created
            // Else there is an error on our server
            if($user) {
                Auth::login($user);
                $token = $user->createToken('authToken')->plainTextToken;
                return response()->json([
                    'status'  => 200,
                    'token'   => $token,
                    'message' => 'User successfully created and logged in!'
                ], 200);
            } else {
                return response()->json([
                    'status'  => 500,
                    'message' => 'There seems to be a problem in our server. We apologize for the inconvenience. Please try again later.'
                ], 500);
            }
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        // If user exists, read user
        // Else user not found
        if($user->count() > 0) {
            return response()->json([
                'status'  => 200,
                'message' => $user
            ], 200);
        } else {
            return response()->json([
                'status'  => 404,
                'message' => 'User not found!'
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $id)
    {
        $user = User::find($id);
        // If user exists, read user
        // Else user not found
        if($user) {
            return response()->json([
                'status'  => 200,
                'message' => $user
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
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
