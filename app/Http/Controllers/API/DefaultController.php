<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PackageType;
use App\Models\PaymentType;
use Exception;
use Illuminate\Http\Request;

class DefaultController extends Controller
{
    public function getPackageTypes ()
    {
        try{
            return response()->json([
                'status' => 'success',
                'types' => PackageType::all()
            ]);
        }catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to get package types'
            ]);
        }
    }

     public function getPaymentTypes ()
    {
        try{
            return response()->json([
                'status' => 'success',
                'paymenttypes' => PaymentType::all()
            ]);
        }catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to get payment methods'
            ]);
        }
    }
}