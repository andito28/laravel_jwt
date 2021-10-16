<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        if(!$token = JWTAuth::attempt($request->only('email','password'))){
            return response()->json([
                'success' => false,
                'message' => 'email or password is incorrect'
            ],401);
        }
        

        return response()->json([
            'success' => true,
            'data' => auth()->user(),
            'token' => $token
        ],200);
    }
}
