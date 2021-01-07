<?php

namespace App;

use DB;
use App\Post;
use App\Message;

use App\Session;
use App\Chatroom;
use App\TutorLevel;
use Carbon\Carbon;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Log;


class User extends Authenticatable
{
    use Notifiable;

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

    // customized reset password
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token, request()->is_tutor));
    }

    public function getChattingRoute() {
        return route('chatting.index') . "?toViewOtherUserId=" . $this->id;
    }

    public function getIntroduction() {
        $secondMajor = $this->secondMajor;
        $secondMajorString = $secondMajor ? " and {$secondMajor->major}" : "";

        return $this->introduction ?? "Hi, I am {$this->first_name} {$this->last_name}, a {$this->schoolYear->school_year} studying {$this->firstMajor->major}{$secondMajorString}. I promise to provide the best tutoring services with a good price. Please feel free to request a tutor session with me or ask me anything.";
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

    public function characteristics() {
        return $this->belongsToMany('App\Characteristic');
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

    private function recommendedTutors() {
        if(!$this->is_tutor) {
            $courseIds = $this->courses()->pluck('id');
            $recommendedTutors = User::where('users.is_tutor', true)
                                ->join('course_user', 'course_user.user_id', '=', 'users.id')
                                ->join('courses', 'courses.id', 'course_user.course_id')
                                ->whereIn('courses.id', $courseIds)
                                ->where('users.email', '!=', $this->email)
                                ->get();
            $recommendedTutors = $recommendedTutors
                                    ->random(min(4, $recommendedTutors->count()));

            if($recommendedTutors->count() < 4) {
                $tutorIds = $recommendedTutors->pluck('id');
                $tutors = User::where('users.is_tutor', true)
                            ->where(function($query) {
                                // if is null, then assign -1 to it so that null != null
                                $query->where('users.first_major_id', $this->first_major_id ?? -1)
                                    ->orWhere('users.second_major_id', $this->first_major_id ?? -1)
                                    ->orWhere('users.first_major_id', $this->second_major_id ?? -1)
                                    ->orWhere('users.second_major_id', $this->second_major_id ?? -1);
                            })
                            ->whereNotIn('id', $tutorIds)
                            ->where('users.email', '!=', $this->email)
                            ->get();
                // I want to get a total of (4 - $recommendedTutors->count()) tutors here
                $tutors= $tutors->random(min(4 - $recommendedTutors->count(), $tutors->count()));

                $recommendedTutors = $recommendedTutors->merge($tutors);

                // if there are still < 4 tutors, then randomly pick from the tutors
                if($recommendedTutors->count() < 4) {
                    $tutorIds = $recommendedTutors->pluck('id');
                    $tutors = User::where('users.is_tutor', true)
                                    ->whereNotIn('id', $tutorIds)
                                    ->where('users.email', '!=', $this->email)
                                    ->get();
                    // I want to get a total of (4 - $recommendedTutors->count()) tutors here
                    $tutors= $tutors->random(min(4 - $recommendedTutors->count(), $tutors->count()));
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
        $newUser->tutor_level_id = null;
        $newUser->introduction = null;
        $newUser->is_invalid = false;
        $newUser->save();
        return $newUser;
    }

    public function createTutorIdentityFromStudent() {
        $newUser = $this->replicate();
        $newUser->is_tutor = 1;
        $newUser->is_invalid = true;
        $newUser->tutor_level_id = 1;
        $newUser->invalid_reason = 'The user did not finish all the steps when registering from a student to a tutor.';
        $newUser->invalid_redirect_route_name = 'switch-account.register-to-be-tutor';
        $newUser->save();
        return $newUser;
    }


    public function tutorRequests() {
        return $this->hasMany('App\TutorRequest', $this->is_tutor ? 'tutor_id' : 'student_id');
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
        return number_format((float)$this->aboutReviews()->avg('star_rating'), 1, '.', '');
    }

    public function getFiveStarReviewPercentage() {
        $reviewCnt = $this->aboutReviews()->count();
        if($reviewCnt == 0)
            return 0;

        $fiveStarCnt = $this->aboutReviews()
                            ->where('star_rating', 5)
                            ->count();

        return $fiveStarCnt / $reviewCnt * 100;
    }

    public function hasDualIdentities() {
        return User::where('email', $this->email)->where('is_invalid', false)->count() == 2;
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

    public function sessions() {
        return $this
                    ->hasMany('App\Session', $this->is_tutor ? 'tutor_id' : 'student_id');
    }

    public function getMessages($otherUser) {
        return Message::where(function($query) use ($otherUser) {
            $query->where('from', $this->id)->where('to', $otherUser->id);
        })->orWhere(function($query) use ($otherUser) {
            $query->where('to', $this->id)->where('from', $otherUser->id);
        })->get();
    }

    public function getChatrooms() {
        return Chatroom::where('user_id_1', $this->id)->orWhere('user_id_2', $this->id)->orderBy('created_at', 'desc')->get();
    }

    public function isAdmin() {
        return Admin::where('email', $this->email)->exists();
    }

    public function getParticipatedPosts(){
        return Post::select("posts.*")
            ->leftJoin('post_user', 'post_user.post_id','=','posts.id')
            ->leftJoin('replies','replies.post_id','=','posts.id')
            ->where('posts.user_id',$this->id)
            ->orWhere('post_user.user_id',$this->id)
            ->orWhere(function ($query) {
                $query->where('replies.is_direct_reply', '=', 1)
                      ->Where('replies.user_id', '=', $this->id);
            })
            ->distinct()
            ->get();
    }









    // ========================= below are legacy code =============
    public function pastTutors($num) {
        $pastTutors = Session::select('*', DB::raw('count(*) as count, max(date) as date'))
                ->join('users', 'sessions.tutor_id', '=', 'users.id')
                ->where('student_id', $this->id)
                ->where('is_upcoming', 0)
                ->where('is_canceled', 0)
                ->groupBy('sessions.tutor_id')
                ->limit($num)
                ->orderBy('date', 'DESC')
                ->get();

        return $pastTutors;
    }

    public static function updateVerifyStatus() {
        // get id of verified users
        $verifiedUsersQuery = DB::table('course_user')->select("course_user.user_id")
        ->join("verified_courses", function($join){
            $join->on("verified_courses.course_id","=","course_user.course_id")
        ->on("verified_courses.user_id","=","course_user.user_id");
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
    }

    // check whether the user with $user_id is bookmarked by the current user
    public function bookmarked($userId) {
        return $this->bookmarks()->where('id', '=', $userId)->count() > 0;
    }

    // check whether the course with $course_id is already faved by the current user
    public function favedCourse($course_id) {
        return $this->courses()->where('id', '=', $course_id)->count() > 0;
    }

    // check whether the characteristic with $characteristic_id is already faved by the current userrating
    public function favedCharacteristic($characteristic_id) {
        return $this->characteristics()->where('id', '=', $characteristic_id)->count() > 0;
    }

    // get the  of the user as the reviewee
    public function getRating() {
        $avg = User::join('reviews', 'reviewee_id', '=', 'users.id')
                    ->where('users.id', '=', $this->id)
                    ->avg('star_rating');

        return $avg ? number_format((float)$avg, 1, '.', '') : NULL;
    }

    // get the rating of the user as the reviewer
    public function getRatingAsReviewer() {
        $avg = User::join('reviews', 'reviewer_id', '=', 'users.id')
                    ->where('users.id', '=', $this->id)
                    ->avg('star_rating');

        return $avg ? number_format((float)$avg, 1, '.', '') : NULL;
    }

    public function clearTutorAvailableTime() {
        $tutors = User::where('is_tutor', 1)->get();
        foreach($tutors as $tutor)
            $tutor->availableTimes()->where('available_time_end','<=', Carbon::now())->delete();
    }

    // Payments
    public function paymentMethod() {
        return $this->hasOne('App\PaymentMethod')->withDefault();
    }

    // add user experience and update level
    // $experienceToAdd : double, when $experienceToAdd is negative, it means subtracting experience
    public function addExperience($experienceToAdd){
        // calculate points
        $this->experience_points += $experienceToAdd;
        // update tutor level id in user
        $this->tutor_level_id = TutorLevel::getLevelFromExperience($this->experience_points)->id;
        // save
        $this->save();
    }

    // return tutor level bonus rate of current user
    // return: double
    public function getUserBonusRate(){
        return $this->tutorLevel()->get()[0]->bonus_rate;
    }
}
