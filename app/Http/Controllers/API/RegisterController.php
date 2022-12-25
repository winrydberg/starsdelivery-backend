<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function registerUser(Request $request){

        $user = User::where('phoneno', '233'.substr($request->phoneno, -9))->first();
        if($user){
            return response()->json([
                'status' => 'error',
                'message' => 'Phone No already taken'
            ]);
        }
        $validator = Validator::make($request->all(), [
            'firstname' =>'required',
            'lastname' =>'required',
            'password' => 'required',
            'phoneno' => 'required|unique:users,phoneno',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phoneno' => '233'.substr($request->phoneno, -9),
            'registrationtoken' => $request->registrationtoken,
            'email' => $request->email,
            'device_name' => '233'.substr($request->phoneno, -9),
            'referalcode' => mt_rand(1000, 99999),
        ]);

        if($user!= null){
            return response()->json([
                'status' => 'success',
                'user' => $user,
                'token' => $user->createToken($request->phoneno)->plainTextToken,
                'message' => 'User account successfully created'
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Oops Something went wrong. Please try again'
            ]);
        }


    }
}