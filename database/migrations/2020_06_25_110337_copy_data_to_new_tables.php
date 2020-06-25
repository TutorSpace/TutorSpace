<?php

use App\Available_time;
use App\BookmarkToUser;
use App\Course;
use App\CancelReason;
use App\Characteristic;
use App\CharacteristicToUser;
use App\Chatroom;
use App\CourseToUser;
use App\Dashboard_post;
use App\Major;
use App\Message;
use App\Report;
use App\ReportReason;
use App\Review;
use App\School_year;
use App\Session;
use App\Subject;
use App\SubjectToUser;
use App\Tutor_request;
use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/*
    Copies old_values and saves into new database.

    @param  array   $old_value
    @return void
*/
function saveModels($old_values) {
    foreach ($old_values as $old_value) {
        $new_value = $old_value->replicate();
        $new_value->setConnection('mysql2');
        try {
            $new_value->save();
        } catch (Exception $e) {
            echo "Invalid data entry. Discarded.\n";
        }
    }
}

class CopyDataToNewTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $old_values = CancelReason::all();
        saveModels($old_values);
        $old_values = Characteristic::all();
        saveModels($old_values);
        $old_values = Course::all();
        saveModels($old_values);
        $old_values = Major::all();
        saveModels($old_values);
        $old_values = ReportReason::all();
        saveModels($old_values);
        $old_values = School_year::all();
        saveModels($old_values);
        $old_values = Subject::all();
        saveModels($old_values);
        $old_values = User::all();
        foreach ($old_values as $old_value) {
            $new_value = $old_value->replicate();
            $new_value->setConnection('mysql2');
            $new_value->first_name = $new_value->full_name;
            $new_value->last_name = $new_value->full_name;
            $new_value->first_major_id = $new_value->major_id;
            $new_value->second_major_id = null;
            unset($new_value->full_name);
            unset($new_value->major_id);
            try {
                $new_value->save();
            } catch (Exception $e) {
                echo "Invalid data entry. Discarded.\n";
            }
        }
        $old_values = BookmarkToUser::all();
        saveModels($old_values);
        $old_values = Available_time::all();
        saveModels($old_values);
        $old_values = CharacteristicToUser::all();
        saveModels($old_values);
        $old_values = Chatroom::all();
        saveModels($old_values);
        $old_values = CourseToUser::all();
        saveModels($old_values);
        $old_values = Major::all();
        saveModels($old_values);
        $old_values = Dashboard_post::all();
        saveModels($old_values);
        $old_values = Message::all();
        saveModels($old_values);
        $old_values = Report::all();
        saveModels($old_values);
        $old_values = Session::all();
        saveModels($old_values);
        $old_values = Review::all();
        saveModels($old_values);
        $old_values = SubjectToUser::all();
        saveModels($old_values);
        $old_values = Tutor_request::all();
        saveModels($old_values);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::connection('mysql2')->statement("SET foreign_key_checks=0");
        CancelReason::on('mysql2')->truncate();
        Characteristic::on('mysql2')->truncate();
        Course::on('mysql2')->truncate();
        Major::on('mysql2')->truncate();
        ReportReason::on('mysql2')->truncate();
        School_year::on('mysql2')->truncate();
        Subject::on('mysql2')->truncate();
        User::on('mysql2')->truncate();
        BookmarkToUser::on('mysql2')->truncate();
        Available_time::on('mysql2')->truncate();
        CharacteristicToUser::on('mysql2')->truncate();
        Chatroom::on('mysql2')->truncate();
        CourseToUser::on('mysql2')->truncate();
        Major::on('mysql2')->truncate();
        Dashboard_post::on('mysql2')->truncate();
        Message::on('mysql2')->truncate();
        Report::on('mysql2')->truncate();
        Session::on('mysql2')->truncate();
        Review::on('mysql2')->truncate();
        SubjectToUser::on('mysql2')->truncate();
        Tutor_request::on('mysql2')->truncate();
        DB::connection('mysql2')->statement("SET foreign_key_checks=1");
    }
}
