<?php

namespace App\Http\Controllers;

use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only([
           'email',
           'password',
        ]);
        if (Auth::attempt($credentials)) {
            $token = Auth::user()->createToken($request->name?:'No name', [$request->scope]);


            return response()->json([
                'status' => true,
                'access_token' => $token->accessToken,
            ]);
        }

        return response()->json([
            'status' => false
        ]);
    }

    public function logout()
    {
        if (Auth::user()->token()->revoke()) {
            return response()->json([
                'status' => true
            ]);
        }
    }

    public function view()
    {
        dd(123123);
    }
}
