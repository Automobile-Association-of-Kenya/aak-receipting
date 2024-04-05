<?php

namespace App\Observers;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentObsrver
{
    /**
     * Handle the Payment "created" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function created(Payment $payment)
    {
        $data = [
            'CustomerName' => $payment->member->firstName . ' ' . $payment->member->secondName . ' ' . $payment->member->surNameName,
            'CustomerEmail' => $payment->member->emailAddress,
            'IDNO' => $payment->member->idNo,
            'PhoneNo' => $payment->member->mobilePhoneNumber,
            'ReceiptAmount' => $payment->amount,
            `Branch` => $payment->invoice->branch->name,
            'ReceiptNo' => $payment->receipt_no,
            'InvoiceNo' => $payment->invoice->invoice_no,
            'Narration' => $payment->description,
            'PostedBy' => $payment->user->name,
            'ExternalDocNo' => null,
            'GL1' => 1,
            'GLAmount' => $payment->invoice->amount,
            'InvoiceDate' => $payment->invoice->date,
            'ReceiptDate' => $payment->date,
            'Paymode ' => $payment->method,
        ];
        Log::info($data);
        $response = Http::post("http://197.248.13.206:7048/DynamicsNAV100/ODataV4/Company('AAKENYA%20LTD')/RRM",$data);
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
