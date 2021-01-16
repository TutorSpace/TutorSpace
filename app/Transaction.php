<?php

namespace App;

use Carbon\Carbon;
use App\Events\TutoringHourEnded;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Payment\StripeApiController;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class Transaction extends Model
{
    use Uuid;

    protected $keyType = 'string';
    public $incrementing = false;

    public function session() {
        return $this->belongsTo('App\Session');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    // chain this function with other functions
    // e.g. unpaidPayments()->get(), unpaidPayments()->count()
    public static function unpaidPayments() {
        return Transaction::where('invoice_status', 'open')->where('user_id', Auth::id());
    }

    // specify time to finalize after session end
    public static function finalizeInvoice($timeAfterSessionEnd) {
        $transactionsToCharge = Transaction::join("sessions","sessions.id","=","transactions.session_id") // join

        ->whereRaw("TIMESTAMPDIFF (MINUTE, sessions.session_time_end, '" . Carbon::now() . "' ) >= ?", $timeAfterSessionEnd) // ? minutes after session end
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
                app(StripeApiController::class)->createSessionBonus(round($transaction->amount * $bonus_rate), $transaction->session);
            }

            // Trigger event to add experience
            event(new TutoringHourEnded($tutor, $session));
        }
    }

    public static function sendUnpaidInvoices($hoursAfterLastUpdate){
        app(StripeApiController::class)->sendOpenInvoiceToCustomer($hoursAfterLastUpdate);
    }
}
