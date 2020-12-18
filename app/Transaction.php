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
    public static function finalizeInvoice(){
        $invoicesToCharge = Transaction::select("transactions.invoice_id")
        ->join("sessions","sessions.id","=","transactions.session_id")
        ->whereRaw("TIMESTAMPDIFF (MINUTE, sessions.session_time_end,CURRENT_TIMESTAMP()) >= 120") // 2 hours after end
        ->where("transactions.is_successful",0)
        ->where("transactions.refund_id",NULL)
        //TODO: add is cancel = 0
        ->where("transactions.is_cancelled",0)
        ->get();

        // charge each one
        $stripeApiController = new StripeApiController();
        forEach($invoicesToCharge as $invoice){
             $stripeApiController->finalizeInvoice($invoice->invoice_id);
        }
    }
}
