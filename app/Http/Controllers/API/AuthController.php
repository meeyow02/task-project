<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'role' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email|lowercase',
            'password' => 'required|string|min:8',
        ]);

        try {
            DB::transaction(function () use ($request) {
                User::create([
                    'role' => $request->role,
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
            });

            return response()->json(new ResponseResource('User register successfully.', []), 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required|string|min:8',
        ]);

        try {
            $user = User::where('name', $request['name'])->first();
            if (!$user || !Hash::check($request['password'], $user->password)) {
                return response()->json([
                    'message' => 'Validation Error.'
                ], 401);
            }
            $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;

            return response()->json(new ResponseResource('User login successfully.', [
                'token' => $token,
                'name' => $user->name,
            ]), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
