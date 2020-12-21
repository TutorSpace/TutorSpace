<?php

namespace App;

use App\Http\Controllers\payment\StripeApiController;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $timestamp = true;

    public function session() {
        return $this->belongsTo('App\Session');
    }
    public static function finalizeInvoice($timeAfterSessionEnd) {
        $invoicesToCharge = Transaction::select("transactions.invoice_id")
        ->join("sessions","sessions.id","=","transactions.session_id") // join
        ->whereRaw("TIMESTAMPDIFF (MINUTE, sessions.session_time_end,CURRENT_TIMESTAMP()) >= ?", $timeAfterSessionEnd) // 2 hours after end
        ->where("transactions.invoice_status","draft") // invoice status => draft
        ->where("transactions.refund_id",NULL) // not a refund
        ->where("sessions.is_canceled",0) // not canceled
        ->get();

        // charge each one
        $stripeApiController = new StripeApiController();
        forEach($invoicesToCharge as $invoice){
             $stripeApiController->finalizeInvoice($invoice->invoice_id); // finalize invoice
        }
    }

    public static function sendUnpaidInvoices($hoursAfterLastUpdate){
        $stripeApiController = new StripeApiController();
        $stripeApiController->sendOpenInvoiceToCustomer($hoursAfterLastUpdate);
    }
}
