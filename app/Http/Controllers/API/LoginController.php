<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * 
     */
    public function authenticateUser(Request $request){
        Log::info($request->all());
        $validator = Validator::make($request->all(), [
            'phoneno' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }
     
        $user = User::where('phoneno', '233'.substr($request->phoneno, -9))->first();
     
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'user' => $user,
                'message' => 'Invalid Login Credentials'
            ]);
        }else{
            return response()->json([
                'status' => 'success',
                'message' => 'Login Successful',
                'user' => $user,
                'token' => $user->createToken($request->phoneno)->plainTextToken
            ]);
        }
    }

    
}