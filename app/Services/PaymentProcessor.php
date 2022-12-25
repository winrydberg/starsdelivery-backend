<?php

namespace App\Services;

use App\Models\Delivery;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentProcessor {

    public $baseUrl ='';

    public function sendPayment(Transaction $transaction, Delivery $delivery){
        // Http::post($this->baseUrl, [
        //     ''
        // ]);
        Log::info("HTTP request sent to Paystack");
    }
}