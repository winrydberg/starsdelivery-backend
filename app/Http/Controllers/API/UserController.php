<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * 
     */
    public function getAuthUser(){
       try{
         return response()->json([
            'status' => 'success',
            'user' => Auth::user()
        ]);
       }catch(Exception $e){
        return response()->json([
            'status' => 'error',
            'message' => 'Oops something went wrong. Please login'
        ]);
       }
    }
}