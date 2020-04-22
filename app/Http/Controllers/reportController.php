<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Report;

class reportController extends Controller
{
    public function showReport(Request $request, User $reportee) {
        $user = Auth::user();
        $from = $request->input('from');

        if($user->is_tutor) {
            return "<h1>Reporting tutor functionality is coming soon! We only support reporting student right now!</h1>";
        }
        else {

            return view('report.report_tutor', [
                'user' => $user,
                'reportee' => $reportee,
                'from' => $from
            ]);
        }
    }

    public function postReport(Request $request, User $reportee) {
        $request->validate([
            'report-reason' => [
                'required',
                'exists:report_reasons,id'
            ],
            'report-content' => [
                'required'
            ]
        ]);

        $user = Auth::user();
        if($user->is_tutor) {
            dd("<h1>Reporting tutor functionality is coming soon! We only support reporting student right now!</h1>");
        }
        else {
            $reportReasonId = $request->input('report-reason');
            $reportContent = $request->input('report-content');

            $report = new Report();
            $report->reporter_id = $user->id;
            $report->reportee_id = $reportee->id;
            $report->report_reason_id = $reportReasonId;
            $report->report = $reportContent;
            $report->save();

            return redirect()->route('home')->with([
                'reportSuccess' => 'Successfully report ' . $reportee->full_name . '!'
            ]);

        }
    }

}
