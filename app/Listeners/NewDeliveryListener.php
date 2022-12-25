<?php

namespace App\Listeners;

use App\Events\NewDeliveryEvent;
use App\Jobs\ProcessPayment;
use App\Models\DeliveryMode;
use App\Models\DropOff;
use App\Models\PaymentType;
use App\Models\Transaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewDeliveryListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NewDeliveryEvent  $event
     * @return void
     */
    public function handle(NewDeliveryEvent $event)
    {
        $deliveryMode = DeliveryMode::find($event->delivery->delivery_mode_id);

        $dropOffs = DropOff::where('delivery_id', $event->delivery->id)->get();

        $totalAmount = 0;
        $pickuplat = $event->delivery->pickup_lat;
        $pickuplng = $event->delivery->pickup_lng;

        foreach($dropOffs as $dropoff){
            $totalAmount += $this->calculateDeliveryAmount($pickuplat, $pickuplng, $dropoff->dropoff_lat, $dropoff->dropoff_lng,6371, $deliveryMode->amount_per_km);
            $pickuplat = $dropoff->dropoff_lat;
            $pickuplng = $dropoff->dropoff_lng;
        }
       
        
        $event->delivery->update([
            'delivery_fare' => $totalAmount
        ]);
        $transaction = Transaction::create([
            'delivery_id' => $event->delivery->id,
            'amount' => $totalAmount,
            'txnno' => 'TXN'.mt_rand(10000,9999999999),
            'user_id' => $event->delivery->user_id,
            'rider_id' => $event->delivery->rider_id,
            'payment_type_id' => $event->delivery->payment_type_id,
            'paid' => false,
            'user_id' => $event->delivery->user_id
        ]);

        $paymentType = PaymentType::find($event->delivery->payment_type_id);
        if($paymentType && $paymentType->type != 'cash'){
           ProcessPayment::dispatch($transaction, $event->delivery);
        }
    }

    public function calculateDeliveryAmount($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371, $amt_per_km = 2){
         // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $lonDelta = $lonTo - $lonFrom;
        $a = pow(cos($latTo) * sin($lonDelta), 2) +
            pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

        $angle = atan2(sqrt($a), $b);
        $distance_in_km = $angle * $earthRadius;

        return $distance_in_km * $amt_per_km;
    }
}