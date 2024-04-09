<?php

namespace App\Observers;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentObsrver
{
    // function creating(Payment $payment) {
    //     $payment->user_id = auth()->user()->id;
    // }
    /**
     * Handle the Payment "created" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function created(Payment $payment)
    {
        $data = [
            
            'IDNo' => $payment->member->idNo,
            'InvoiceNo' => $payment->invoice->invoice_no,
            'GL1' => null,
            'CustomerName' => $payment->member->firstName . ' ' . $payment->member->secondName . ' ' . $payment->member->surNameName,
            'CustomerEmail' => $payment->member->emailAddress,
            'PhoneNo' => $payment->member->mobilePhoneNumber,
            'ReceiptAmount' => $payment->amount,
            'Branch' => $payment->invoice->branch->name,
            'ReceiptNo' => $payment->receipt_no,
            'Narration' => $payment->description,
            'PostedBy' => $payment->user->name,
            'ExternalDocNo' => $payment->ref_no,
            'GLAmount1' => $payment->invoice->amount,
            'InvoiceDate' => $payment->invoice->date,
            'ReceiptDate' => $payment->date,
            'Paymode' => $payment->method,
        ];
        Log::info($data);
        $response = Http::withBasicAuth('integration', 'ieceePhaeshie9yo')
            ->post("http://197.248.13.206:7048/DynamicsNAV100/ODataV4/Company('AAKENYALTD')/RRM", $data);
        Log::alert($response);
    }

    /**
     * Handle the Payment "updated" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function updated(Payment $payment)
    {
        //
    }

    /**
     * Handle the Payment "deleted" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function deleted(Payment $payment)
    {
        //
    }

    /**
     * Handle the Payment "restored" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function restored(Payment $payment)
    {
        //
    }

    /**
     * Handle the Payment "force deleted" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function forceDeleted(Payment $payment)
    {
        //
    }
}
