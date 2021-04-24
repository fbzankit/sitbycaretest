<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Tyman\JWTAuth\Exceptions\JWTException;
use Validator;
use App\Models\User;

class Login extends Controller
{
    
    public function login(Request $request)
	  {
	    $rules = [
	        'email'      => 'required|email|max:255',
	        'password'   => 'required|min:6',
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
	      $input = $request->only('email', 'password');
	      $jwt_token = null;

	      if (!$jwt_token = JWTAuth::attempt($input)) {
	          return response()->json([
	              'success' => false,
	              'message' => 'Invalid Email or Password',
	          ]);
	      }
	      $user = JWTAuth::user();
	      // $user->update(['last_login' => date('Y-m-d H:i:s')]);
	      // $user->profile;

	      return response()->json([
	          'success' => true,
	          'token' => $jwt_token,
	          'data'    => $user,
	      ]);
	  }

	  //function to get user using token
	  public function profile(Request $request){
	  	$token = JWTAuth::getToken();
	  	return JWTAuth::toUser($token);
	  }

	  //function to get user using token
	  public function logout(Request $request){
	  	$token = JWTAuth::getToken();
	  	JWTAuth::invalidate($token);
	  	return response()->json([
	          'success' => true,
	          'message' => 'Logout Successfully'
	      ]);
	  }
}
