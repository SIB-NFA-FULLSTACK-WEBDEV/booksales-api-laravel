<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    public function register(Request $request){
        //1. Set up validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8',
        ]);
        //2. Cek validator
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 422);
        }
        //3. Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        //4. Cek keberhasilan
        if ($user) {
            return response()->json([
                'success' => 'true',
                'message' => 'User created successfully.',
                'data' => $user,
            ], 201);
        }
        //5. Cek gagal
        return response()->json([
            'success' => 'false',
            'message' => 'Failed to create user.',
        ], 409);
    }

    public function login(Request $request){
            //1. Set up validator
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            //2. Cek validator
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            //3. Get kredensial
            $credentials = $request->only('email', 'password');

            //4. Generate token
            if (!$token = auth()->guard('api')->attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email or password is incorrect.',
                ], 401);
            }

            //5. Get user
            $user = auth()->guard('api')->user();

            //6. Return response
            return response()->json([
                'success' => true,
                'message' => 'Login successful.',
                'data' => [
                    'user' => $user,
                    'token' => $token,
                ],
            ], 200);
        }

        public function logout(Request $request){
            //1. Try 
            //1. Invalidate token
            //2. Cek isSuccess

            //catch
            //1. cek isFailed

            try {
                JWTAuth::invalidate(JWTAuth::getToken());
                return response()->json([
                    'success' => true,
                    'message' => 'Logout successful.',
                ], 200);
            } catch (JWTException $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to logout. Please try again.',
                ], 500);
            }
        }
    }


