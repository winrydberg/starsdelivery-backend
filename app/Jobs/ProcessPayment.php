<?php

namespace App\Jobs;

use App\Models\Delivery;
use App\Models\Transaction;
use App\Services\PaymentProcessor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $delivery;
    public $transaction;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction, Delivery $delivery, )
    {
        $this->delivery = $delivery;
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PaymentProcessor $paymentProcessor)
    {
        $paymentProcessor->sendPayment($this->transaction, $this->delivery);
    }
}