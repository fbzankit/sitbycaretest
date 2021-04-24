<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Tyman\JWTAuth\Exceptions\JWTException;
use Validator;
use Hash;
use App\Models\User;


class Register extends Controller
{
	// Function to register a User
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|min:6',
            'mobile' => 'required|string'
        ];
        $check = Validator::make($request->all(),$rules);
        if($check->fails())
        {
            return response()->json([
                'success' => false,
                'message'   => $check->errors()->first(),
                'data'    => (object)[],
            ],200);
        }

        $request['password'] = Hash::make($request->get('password'));

        $user = User::create($request->all());
        return response()->json([
            'success' => true,
            'token'   => JWTAuth::fromUser($user),
            'data'    => $user,
        ]);
    }

}
