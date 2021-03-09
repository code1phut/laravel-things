<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // register user
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'user_name' => 'required',
            'phone_number' => 'numeric',
            'role' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3,confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        User::create([
            'user_name' => $request->get('user_name'),
            'full_name' => $request->get('full_name'),
            'phone_number' => $request->get('phone_number'),
            'role' => $request->get('role'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
//            'status' => bcrypt($request->get('password')),
        ]);

        return response()->json(['status' => 'success'], 200);
    }

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {

        // TODO Login = user_name or email
//        if ($request->get('user_name')) {
//            $input = $request->get('user_name');
//        } else {
//            $input = $request->get('email');
//        }

        //Get Token
        $credentials = $request->only(
            'email', 'password');

        // check token empty
        if ($token = $this->guard()->attempt($credentials)) {
            return response()->json(['status' => 'Login Successfully!'], 200)->header('Authorization', $token);
        }

        return response()->json(['error' => 'unAuthorize'], 401);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        $user = User::find(Auth::user()->id);

        return response()->json([
            'status' => 'success',
            'data' => $user,
        ]);
    }

    public function refresh(): \Illuminate\Http\JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    private function guard() {
        return Auth::guard();
    }
}
