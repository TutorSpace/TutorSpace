<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use Facades\App\User;

class UpdateAllTutorVerification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update-tutor-verification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update tutor is_verified column based on course_user and course_verifications tables';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // get id of verified users
        $verifiedUsersQuery = DB::table('course_user')->select("course_user.user_id")
        ->join("course_verifications", function($join){
            $join->on("course_verifications.course_id","=","course_user.course_id")
        ->on("course_verifications.user_id","=","course_user.user_id");
        })
        ->distinct();

        //verified users update
        User::whereIn('id',$verifiedUsersQuery)->update([
            'is_tutor_verified' => '1'
        ]);        
        

        // unverified users update
        User::whereNotIn('id',$verifiedUsersQuery)->update([
            'is_tutor_verified' => '0'
        ]);     

        echo "Successfully update is_tutor_verified: " . now() . "\n";
    }
}
