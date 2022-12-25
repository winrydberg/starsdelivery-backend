<?php

namespace App\Http\Controllers\API;

use App\Events\NewDeliveryEvent;
use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\DropOff;
use App\Models\PaymentType;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DeliveryController extends Controller
{
    //
    public function newDelivery(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'pickup_loc_name' => 'required',
                'pickup_lat' =>'required',
                'pickup_lng' =>'required',
                'dropoffs' => 'required',
                'pickup_msisdn' => 'required',
                'package_type_id' =>'required',
                'payment_type_id' => 'required',
                'delivery_mode_id' => 'required'
            ],[
                'pickup_loc_name.required' => 'Please select a pickup location',
                'pickup_lat.required' => 'Please select a pickup location',
                'pickup_lng.required' => 'Please select a pickup location',
                'dropoff_loc_name.required' => 'Please select a drop off location',
                'dropoff_lat.required' => 'Please select a drop off location',
                'dropoff_lng.required' => 'Please select a drop off location',
                'pickup_msisdn.required' => 'Please enter a pickup person\'s phoneno',
                'dropoff_msisdn.required' => 'Please enter a drop off person\'s phoneno',
                'package_type_id.required' => 'Please select a package type',
                'payment_type_id.required' => 'Please select a payment method',
                'delivery_mode_id.required' => 'Please select mode of delivery'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first()
                ]);
            }



            $delivery = Delivery::create([
                'pickup_loc_name' => $request->pickup_loc_name,
                'pickup_lat' => $request->pickup_lat,
                'pickup_lng' => $request->pickup_lng,
                'pickup_msisdn' => '233'.substr($request->pickup_msisdn, -9),
                'package_type_id' => $request->package_type_id,
                'payment_type_id' => $request->payment_type_id,
                'note' => $request->note,
                'payment_no' => $request->payment_no,
                'delivery_mode_id' => $request->delivery_mode_id,
                'user_id' => Auth::user()->id
            ]);

            $dropoffs = $request->dropoffs;

            

            if(is_array($dropoffs)){
                foreach($dropoffs as $doff){
                    DropOff::create([
                        'dropoff_loc_name' => $doff['loc_name'],
                        'dropoff_lat' => $doff['lat'],
                        'dropoff_lng' => $doff['lng'],
                        'dropoff_msisdn' => '233'.substr($doff['msisdn'], -9),
                        'delivery_id' => $delivery->id
                    ]);
                }
            }


            if($delivery != null){

                event(new NewDeliveryEvent($delivery));

                $paymentType = PaymentType::find($delivery->payment_type_id);
                if($paymentType && $paymentType->type != 'cash'){
                    //dispatch a new payment event
                    return response()->json([
                        'status' => 'success',
                        'next' => 1,
                        'message' => 'Request received. Please approve payment prompt to complete delivery request'
                    ]);
                }else{
                    //dispatch a new delivery into the queue
                    return response()->json([
                        'status' => 'success',
                        'next' => 1,
                        'message' => 'Thanks for using our services. One of our dispatch riders will contact you shortly for pickup'
                    ]);
                }
            }else{
                // Log::error($e)s;

                return response()->json([
                    'status' => 'error',
                    'message' => 'Oops something went wrong. SQL Error'
                ]);
            }
        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Oops something went wrong. Unable to process request right now. Please try again.'
            ]);
        }
    }



    
}