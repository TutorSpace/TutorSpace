<?php

namespace App;

use App\Http\Controllers\payment\StripeApiController;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    private static $RATE_HOUR_EXP = 5;

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

            // Add experience
            $avg_rating = (float)$tutor->aboutReviews()->avg('star_rating');
            $total_exp = round(self::$RATE_HOUR_EXP * $avg_rating * $session->getDurationInHour());
            $tutor->addExperience($total_exp);
        }
    }

    public static function sendUnpaidInvoices($hoursAfterLastUpdate){
        app(StripeApiController::class)->sendOpenInvoiceToCustomer($hoursAfterLastUpdate);
    }
}
