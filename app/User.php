<?php

namespace App;

use DB;
use App\Post;
use App\Review;

use App\Message;
use App\Session;
use App\Chatroom;
use Carbon\Carbon;
use App\TutorLevel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\TutorLevelUpNotification;
use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Support\Facades\Session as UserSession;
use Illuminate\Foundation\Auth\User as Authenticatable;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;


class User extends Authenticatable
{
    use Notifiable, Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    CONST RECOMMENDED_TUTORS_CACHE_KEY = 'RECOMMENDED_TUTORS';

    protected $keyType = 'string';
    public $incrementing = false;

    // customized reset password
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token, request()->is_tutor));
    }

    public function getChattingRoute() {
        if(Auth::check() && Auth::id() != $this->id) {
            return route('chatting.index') . "?toViewOtherUserId=" . $this->id;
        } else {
            return "#";
        }
    }

    public function getIntroduction() {
        if($this->is_tutor) {
            $secondMajor = $this->secondMajor;
            $secondMajorString = $secondMajor ? " and {$secondMajor->major}" : "";

            return $this->introduction ?? "Hi, I am {$this->first_name} {$this->last_name}, a {$this->schoolYear->school_year} studying {$this->firstMajor->major}{$secondMajorString}. I promise to provide the best tutoring services with a good price. Please feel free to request a tutor session with me or ask me anything.";
        } else {
            return "Hi, I am {$this->first_name} {$this->last_name}. I am looking forward to having tutoring sessions on this platform.";
        }

    }

    // check whether a user with an email exists and is a student
    public static function existStudent($email) {
        return User::where('email', '=', $email)->where('is_tutor', false)->exists();
    }

    public static function existTutor($email) {
        return User::where('email', '=', $email)->where('is_tutor', true)->exists();
    }

    public static function registeredWithGoogle($email) {
        return User::where('email', '=', $email)->where('google_id', '!=', null)->exists();
    }

    public function firstMajor() {
        return $this->belongsTo('App\Major', 'first_major_id');
    }

    public function secondMajor() {
        return $this->belongsTo('App\Major', 'second_major_id');
    }

    public function minor() {
        return $this->belongsTo('App\Minor', 'minor_id');
    }

    public function schoolYear() {
        return $this->belongsTo('App\SchoolYear');
    }

    public function courses() {
        return $this->belongsToMany('App\Course');
    }

    public function tutorLevel() {
        return $this->belongsTo('App\TutorLevel');
    }

    public function deleteImage() {
        if(!Str::of($this->profile_pic_url)->contains('placeholder')) {
            Storage::delete($this->profile_pic_url);
        }
    }

    // return the profile' daily view count in the past week
    public function viewCntWeek() {
        return $this->views()
                    ->select(['viewed_at', DB::raw('COUNT("viewed_at") as view_count')])
                    ->whereBetween('viewed_at', [
                        // a week is 7 -1 + 1 days including today
                        Carbon::now()->subDays(7 - 1)->format('Y-m-d'),
                        Carbon::now()->format('Y-m-d')
                    ])
                    ->groupBy('viewed_at');
    }

    public static function getViewCntWeek($userId) {
        return View::select([
                        'viewed_at',
                        DB::raw('COUNT("views.viewed_at") as view_count')
                    ])
                    ->where('views.viewable_type', 'App\User')
                    ->whereBetween('views.viewed_at', [
                        // a week is 7 -1 + 1 days including today
                        Carbon::now()->subDays(7 - 1)->format('Y-m-d'),
                        Carbon::now()->format('Y-m-d')
                    ])
                    ->join('users', 'users.id', '=', 'views.viewable_id')
                    ->where('users.id', $userId)
                    ->groupBy('views.viewed_at')
                    ->orderBy('views.viewed_at')
                    ->get();
    }

    // This is for the views table. To get the total view count on this post, siimply retrieve the view_count column
    public function views() {
        return $this->morphMany('App\View', 'viewable');
    }


    // ======================== Forum ======================
    public function posts() {
        return $this->hasMany('App\Post');
    }

    // get the posts that this user replied to
    public function postsReplied() {
        return Post::join('replies', 'replies.post_id', '=', 'posts.id')
                    ->join('users', 'users.id', '=', 'replies.user_id')
                    ->where('users.id', $this->id)
                    ->where('replies.is_direct_reply', true)
                    ->distinct();
    }

    public function replies() {
        return $this->hasMany('App\Reply');
    }

    public function followedPosts() {
        // return $this->belongsToMany('App\Post', 'post_user', 'user_id', 'post_id');
        return $this->belongsToMany('App\Post');
    }

    public function hasFollowedPost($post) {
        return $this->followedPosts()->where('post_id', $post->id)->exists();
    }

    // get all the posts the user upvoted
    public function upvotedPosts() {
        return $this->belongsToMany('App\Post', 'post_user_upvote');
    }

    // return a boolean indicates whether this users likes the given post
    public function hasUpvotedPost($post) {
        return $this->upvotedPosts()->where('post_id', $post->id)->exists();
    }

    // get all the replyes the user upvoted
    public function upvotedReplies() {
        return $this->belongsToMany('App\Reply', 'reply_user_upvote');
    }

    // return a boolean indicates whether this users likes the given reply
    public function hasUpvotedReply($reply) {
        return $this->upvotedReplies()->where('reply_id', $reply->id)->exists();
    }

    public function tags() {
        return $this->belongsToMany('App\Tag');
    }

    // return users that this user bookmarked
    public function bookmarkedUsers() {
        return $this->belongsToMany('App\User', 'bookmark_user', 'user_id', 'bookmarked_user_id');
    }

    // return users who bookmarked the current user
    public function bookmarkedByUsers() {
        return $this->belongsToMany('App\User', 'bookmark_user', 'bookmarked_user_id', 'user_id');
    }

    public function getRecommendedTutorsCacheKey() {
        return self::RECOMMENDED_TUTORS_CACHE_KEY . ".$this->id";
    }

    // todo: modify this method for recommending tutors
    // get recommended tutors
    public function getRecommendedTutors() {
        if(request()->refresh) {
            Cache::forget($this->getRecommendedTutorsCacheKey());
        }
        return Cache::remember(
            $this->getRecommendedTutorsCacheKey(),
            3600,
            function() {
                return $this->recommendedTutors();
            }
        );
    }

    public function recommendedTutors() {
        if(!$this->is_tutor) {
            $courseIds = $this->courses()->pluck('id');
            $recommendedTutors = User::select("users.*")
                                ->where('users.is_tutor', true)
                                ->where('users.is_invalid', false)
                                ->join('course_user', 'course_user.user_id', '=', 'users.id')
                                ->join('courses', 'courses.id', 'course_user.course_id')
                                ->whereIn('courses.id', $courseIds)
                                ->where('users.email', '!=', $this->email)
                                ->distinct()
                                ->get();

            $recommendedTutors = $recommendedTutors
                                    ->random(min(3, $recommendedTutors->count()));

            if($recommendedTutors->count() < 3) {
                $tutorIds = $recommendedTutors->pluck('id');
                $tutors = User::select("users.*")
                            ->where('users.is_tutor', true)
                            ->where('users.is_invalid', false)
                            ->where(function($query) {
                                // if is null, then assign -1 to it so that null != null
                                $query->where('users.first_major_id', $this->first_major_id ?? -1)
                                    ->orWhere('users.second_major_id', $this->first_major_id ?? -1)
                                    ->orWhere('users.first_major_id', $this->second_major_id ?? -1)
                                    ->orWhere('users.second_major_id', $this->second_major_id ?? -1);
                            })
                            ->whereNotIn('id', $tutorIds)
                            ->where('users.email', '!=', $this->email)
                            ->distinct()
                            ->get();
                // I want to get a total of (3 - $recommendedTutors->count()) tutors here
                $tutors= $tutors->random(min(3 - $recommendedTutors->count(), $tutors->count()));

                $recommendedTutors = $recommendedTutors->merge($tutors);
                echo $recommendedTutors;
                // if there are still < 3 tutors, then randomly pick from the tutors
                if($recommendedTutors->count() < 3) {
                    $tutorIds = $recommendedTutors->pluck('id');
                    $tutors = User::select("users.*")
                                    ->where('users.is_tutor', true)
                                    ->where('users.is_invalid', false)
                                    ->whereNotIn('id', $tutorIds)
                                    ->where('users.email', '!=', $this->email)
                                    ->distinct()
                                    ->get();
                    // I want to get a total of (3 - $recommendedTutors->count()) tutors here
                    $tutors= $tutors->random(min(3 - $recommendedTutors->count(), $tutors->count()));

                    $recommendedTutors = $recommendedTutors->merge($tutors);
                }
            }

            return $recommendedTutors;
        }
        return [];
    }

    // switch account
    public function createStudentIdentityFromTutor() {
        $newUser = $this->replicate();
        $newUser->is_tutor = 0;
        $newUser->is_tutor_verified = 0;
        $newUser->hourly_rate = null;
        $newUser->introduction = null;
        $newUser->is_invalid = false;
        $newUser->save();
        return $newUser;
    }

    public function createTutorIdentityFromStudent() {
        $newUser = $this->replicate();
        $newUser->is_tutor = 1;
        $newUser->is_invalid = true;
        $newUser->invalid_reason = 'The user did not finish all the steps when registering from a student to a tutor.';
        $newUser->invalid_redirect_route_name = 'switch-account.register-to-be-tutor';
        $newUser->save();
        return $newUser;
    }

    public function tutorRequests() {
        return $this->hasMany('App\TutorRequest', $this->is_tutor ? 'tutor_id' : 'student_id');
    }

    public function pendingTutorRequests() {
        return $this->tutorRequests()->where('status', 'pending');
    }

    public function availableTimes() {
        return $this->hasMany('App\AvailableTime');
    }

    // return all the reviews written by the current user
    public function writtenReviews() {
        return $this->hasMany('App\Review', 'reviewer_id');
    }

    // return all the reviews about the current user
    public function aboutReviews() {
        return $this->hasMany('App\Review', 'reviewee_id');
    }

    public function getAvgRating() {
        $reviews = $this->aboutReviews();
        if($reviews->exists()) {
            return number_format((double)$this->aboutReviews()->avg('star_rating'), 1, '.', '');
        } else {
            return 'N/A';
        }
    }


    // return  0 <= double <= 1
    public function getStarReviewPercentage($numStars) {
        $reviewCnt = $this->aboutReviews()->count();
        if($reviewCnt == 0)
            return 0;

        $fiveStarCnt = $this->aboutReviews()
                            ->where('star_rating', $numStars)
                            ->count();

        return $fiveStarCnt / $reviewCnt;
    }

    public function getStarReviewCounts($numStars) {
        $starCnt = $this->aboutReviews()
                            ->where('star_rating', $numStars)
                            ->count();
        return $starCnt;
    }

    // no need to check invalid
    public function hasDualIdentities() {
        return User::where('email', $this->email)->count() == 2;
    }

    public function upcomingSessions() {
        return $this->sessions()
                    ->where('is_upcoming', true)
                    ->where('is_canceled', false);
    }

    public function pastSessions() {
        return $this->sessions()
                    ->where('is_upcoming', false)
                    ->where('is_canceled', false);
    }

    public function numSessions() {
        return $this->sessions()
                    ->where('is_canceled', false)
                    ->count();
    }

    // todo: improve the query with select count
    public function numStudents() {
        return Session::join('users', 'sessions.tutor_id', '=', 'users.id')
        ->where('sessions.tutor_id', $this->id)
        ->where('sessions.is_canceled', false)
        ->groupBy('sessions.student_id')
        ->get()
        ->count();
    }

    public function sessions() {
        return $this
                    ->hasMany('App\Session', $this->is_tutor ? 'tutor_id' : 'student_id');
    }

    public function getMessages($otherUser) {
        return Message::where(function($query) use ($otherUser) {
            $query->where('from', $this->id)->where('to', $otherUser->id);
        })->orWhere(function($query) use ($otherUser) {
            $query->where('to', $this->id)->where('from', $otherUser->id);
        })->orderBy('created_at')
        ->get();
    }

    public function getChatrooms() {
        return Chatroom::where('user_id_1', $this->id)->orWhere('user_id_2', $this->id)->orderBy('created_at', 'desc')->get();
    }

    public function isAdmin() {
        return Admin::where('email', $this->email)->exists();
    }

    // get all distinct participated posts
    // participated: my own posts, I followed, I reply directly
    public function participatedPosts(){
        return Post::leftJoin('post_user', 'post_user.post_id','=','posts.id')
            ->leftJoin('replies','replies.post_id','=','posts.id')
            ->where('posts.user_id',$this->id)
            ->orWhere('post_user.user_id',$this->id)
            ->orWhere(function ($query) {
                $query->where('replies.is_direct_reply', '=', 1)
                      ->Where('replies.user_id', '=', $this->id);
            })
            ->distinct();
    }

    public function verifiedCourses() {
        return $this->belongsToMany('App\Course', 'verified_courses', 'user_id', 'course_id');
    }

    public static function updateVerifyStatus() {
        // get id of verified users
        $verifiedUsersQuery = DB::table('course_user')->select("course_user.user_id")
        ->join("verified_courses", function($join){
            $join->on("verified_courses.course_id","=","course_user.course_id")
        ->on("verified_courses.user_id","=","course_user.user_id");
        })
        ->distinct();

        // verified users update
        User::whereIn('id',$verifiedUsersQuery)->update([
            'is_tutor_verified' => '1'
        ]);

        // unverified users update
        User::whereNotIn('id',$verifiedUsersQuery)->update([
            'is_tutor_verified' => '0'
        ]);
    }

    public function clearTutorAvailableTime() {
        $tutors = User::where('is_tutor', 1)->get();
        foreach($tutors as $tutor)
            $tutor->availableTimes()->where('available_time_end','<=', Carbon::now())->delete();
    }

    public function paymentMethod() {
        return $this->hasOne('App\PaymentMethod')->withDefault();
    }

    // check if tutor has stripe account already
    // return: boolean
    // has account: true, no account or not a tutor: false
    public function tutorHasStripeAccount(){
        if ($this->is_tutor){
            return $this->paymentMethod != null && $this->paymentMethod->stripe_account_id != null;
        }
        return false;
    }

    public function cancellationPenalty() {
        return $this->hasMany('App\CancellationPenalty');
    }

    // IMPORTANT! : NOTE this function updates all users with the same email
    // add user experience and update level
    // $experienceToAdd : integer, when $experienceToAdd is negative, it means subtracting experience
    public function addExperience($experienceToAdd){
        $allUsersWithEmail = User::where("email", $this->email)->get();
        $oldLevelId = $this->tutor_level_id;
        foreach ($allUsersWithEmail as $user) {
            $user->experience_points += $experienceToAdd;
            $newTutorLevelId = TutorLevel::getLevelFromExperience($user->experience_points)->id;

            // update tutor level id in user
            $user->tutor_level_id = $newTutorLevelId;

            // save
            $user->save();
        }
        $this->refresh();  // $this !== $user

        // important: tutor level are assumed to be larger with higher tutor level id
        if($newTutorLevelId > $oldLevelId) {
            $this->notify(new TutorLevelUpNotification($oldLevelId, $newTutorLevelId));
        }
    }

    public function ratedSessions() {
        return Session::join('reviews', 'sessions.id', '=', 'reviews.session_id')
                ->where('sessions.is_upcoming', false)
                ->get();
    }

    public function unratedSessions() {
        return Session::select('sessions.*')
                ->leftJoin('reviews', 'sessions.id', '=', 'reviews.session_id')
                ->where('sessions.is_upcoming', false)
                ->where('sessions.student_id', Auth::id())
                ->where('reviews.session_id', null)
                ->get();
    }

    // deduct experience from users after canceling a session (both tutor and student)
    public function cancelSessionExperienceDeduction(){
        $lowerBound = $this->tutorLevel->level_experience_lower_bound;
        $upperBound = $this->tutorLevel->level_experience_upper_bound;
        $nextLevel = TutorLevel::where("level_experience_lower_bound",$upperBound);
        $experienceToSubstract = 0;
        // lowest level: (upper bound - 0) * 20%
        if ($lowerBound < 0){
            $experienceToSubstract = ($upperBound - 0) * 0.2;
        }
        // highest level: (set experience to previous level's lowerbound + 1)
        else if ($nextLevel->count() == 0) {
            $prevLevel = TutorLevel::where("level_experience_upper_bound",$lowerBound)->first();
            $experienceToSubstract = $this->experience_points - $prevLevel->level_experience_lower_bound - 1;
        }
        // normal cases: 20% of current level range
        else {
            $experienceToSubstract = ($upperBound - $lowerBound) * 0.2;
        }

        $this->addExperience(0-$experienceToSubstract);

        return $experienceToSubstract;
    }

    // return tutor level bonus rate of current user as DOUBLE
    public function getUserBonusRate(){
        return $this->tutorLevel->bonus_rate;
    }

    public function currentLevel() {
        return $this->tutorLevel->tutor_level;
    }

    // return tutor_level : String
    // edge case: returns "" if there's no next level
    public function nextLevel() {
        $nextTutorLevel = TutorLevel::getNextLevel($this->experience_points);
        if ($nextTutorLevel){
            return $nextTutorLevel->tutor_level;
        }else{
            return "";
        }
    }

    // progress percentage from current level to next level
    // return : 0 <= Double <= 1
    // edge cases : return 0 if <= 0, return 1 if >= highest level
    public function getLevelProgressPercentage(){
        return TutorLevel::getCurrentPercentageToNextLevel($this->experience_points);
    }

}
