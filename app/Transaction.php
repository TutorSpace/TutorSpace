<?php

namespace App;

use App\Events\TutoringHourEnded;
use App\Http\Controllers\payment\StripeApiController;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function session() {
        return $this->belongsTo('App\Session');
    }

    // todo: henry
    // specify time to finalize after session end
    public static function finalizeInvoice($timeAfterSessionEnd) {
        $transactionsToCharge = Transaction::select("transactions.invoice_id")
        ->join("sessions","sessions.id","=","transactions.session_id") // join
        ->whereRaw("TIMESTAMPDIFF (MINUTE, sessions.session_time_end,CURRENT_TIMESTAMP()) >= ?", $timeAfterSessionEnd) // ? minutes after session end
        ->where("transactions.invoice_status","draft") // invoice status => draft
        ->where("sessions.is_canceled",0) // not canceled
        ->get();

        // charge each one
        forEach($transactionsToCharge as $transaction){
            app(StripeApiController::class)->finalizeInvoice($transaction->invoice_id); // finalize invoice
            $session = $transaction->session;

            // Create bonus if tutor has bonus rate
            $tutor = $session->tutor;
            $bonus_rate = $tutor->getUserBonusRate();
            if ($bonus_rate > 0) {
                app(StripeApiController::class)->createSessionBonus($transaction->amount * $bonus_rate, $transaction->session);
            }

            // Trigger event to add experience
            event(new TutoringHourEnded($tutor, $session));
        }
    }

    public static function sendUnpaidInvoices($hoursAfterLastUpdate){
        app(StripeApiController::class)->sendOpenInvoiceToCustomer($hoursAfterLastUpdate);
    }
}
