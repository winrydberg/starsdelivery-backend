<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'pickup_loc_name' => 'required',
            'dropoff_loc_name' => 'required',
            'pickup_lat' =>'required',
            'pickup_lng' =>'required',
            'dropoff_lat' =>'required',
            'dropoff_lng' =>'required',
            'pickup_msisdn' => 'required',
            'dropoff_msisdn' => 'required',
            'package_type_id' =>'required',
            'payment_type_id' => 'required',
        ];
    }
}