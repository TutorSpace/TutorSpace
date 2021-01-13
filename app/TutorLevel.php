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

    public static function getCurrentPercentageToNextLevel($experience){
        // edge case: before first, after last
        $currentLevel = self::getLevelFromExperience($experience);
        $prevLevel = TutorLevel::where("level_experience_upper_bound",$currentLevel->level_experience_lower_bound);
        $nextLevel = TutorLevel::where("level_experience_lower_bound",$currentLevel->level_experience_upper_bound);
        
        // lowest level
        if ($prevLevel->count() == 0){
            if ($experience < 0){
                return 0;
            }else{
                return ($experience - 0) / $currentLevel->level_experience_upper_bound;
            }
        }

        // max level
        if ($nextLevel->count() == 0){
            return 1;
        }

        // normal cases
        return ($experience - $currentLevel->level_experience_lower_bound) / 
                ($currentLevel->level_experience_upper_bound - $currentLevel->level_experience_lower_bound);
    }

    public static function getNextLevel($experience){
        $currentLevel = self::getLevelFromExperience($experience);
        $nextLevel = TutorLevel::where("level_experience_lower_bound",$currentLevel->level_experience_upper_bound);
        if ($nextLevel->count() == 0){
            return "";
        }
        return $nextLevel->first();
    }
}
