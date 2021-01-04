<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TutorLevel extends Model
{
    protected $table = "tutor_levels";
    public $timestamps = false;

    // return a tutorLevel model from given experience points
    // $experience: double
    public static function getLevelFromExperience($experience){
        // get tutor level within range:  
        // level_experience_lower_bound <= $experience < level_experience_upper_bound
        $resultLevel = TutorLevel::where('level_experience_lower_bound','<=',$experience)
        ->where('level_experience_upper_bound','>', $experience)
        ->get();
        return $resultLevel[0];
    }
}
