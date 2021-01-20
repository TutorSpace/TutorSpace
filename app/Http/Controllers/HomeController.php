<?php

namespace App\Http\Controllers;

use Auth;
use App\Post;
use App\User;
use App\Major;
use App\Minor;
use App\Course;
use App\Session;
use Carbon\Carbon;
use App\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function __construct() {

    }

    public function index() {
        $posts = Post::with(['tags', 'user'])->withCount(['usersUpvoted', 'replies', 'tags']);

        $user = Auth::user();
        $interestedTagIDs = $user->tags()->pluck('id');
        $posts = $posts->join('post_tag', 'posts.id', '=', 'post_tag.post_id')
                        ->join('tags', 'tags.id', '=', 'post_tag.tag_id')
                        ->whereIn('tags.id', $interestedTagIDs)
                        ->where('posts.user_id', '!=', $user->id)
                        ->groupBy(['posts.id'])
                        ->orderByRaw(POST::POPULARITY_FORMULA)
                        ->take(5)
                        ->get();


        // if there are < 5 posts, put other posts here to fill the 5 spots
        if($posts->count() < 5) {
            $posts = $posts->merge(
                Post::with(['tags', 'user'])
                    ->withCount(['usersUpvoted', 'replies', 'tags'])
                    ->where('posts.user_id', '!=', $user->id)
                    ->orderByRaw(POST::POPULARITY_FORMULA)
                    ->get()
            )->take(5);
        }

        return view('home.index', [
            'posts' => $posts,

            // always get the past 7 days' forum notifications
            'forumNotifs' => Auth::user()->notifications()
            ->where(function($query) {
                $query->where('type', 'App\Notifications\Forum\NewFollowupAddedNotification')
                ->orWhere('type', 'App\Notifications\Forum\NewReplyAddedNotification')
                ->orWhere('type', 'App\Notifications\Forum\MarkedAsBestReplyNotification');
            })
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->get()
        ]);

    }

    public function tutorSessions() {
        return view('home.tutor-sessions');
    }

    public function forumActivities() {
        return view('home.forum-activities', [
            'myPosts' => Auth::user()->posts()->with(['tags', 'user'])->withCount(['usersUpvoted', 'replies', 'tags'])->orderBy('posts.created_at', 'DESC')->get(),
            'myFollows' => Auth::user()->followedPosts()->with(['tags', 'user'])->withCount(['usersUpvoted', 'replies', 'tags'])->orderBy('posts.created_at', 'DESC')->get()
        ]);
    }

    public function indexProfile() {
        return view('home.profile');
    }

    public function update(Request $request) {
        $currUser = Auth::user();

        $validator = Validator::make($request->all(), [
            'first-major' => [
                'nullable',
                'required_with:second-major',
                'exists:majors,major',
                'different:second-major',
            ],
            'second-major' => [
                'nullable',
                'exists:majors,major'
            ],
            'minor' => [
                'nullable',
                'exists:minors,minor'
            ],
            'introduction' => [
                'nullable',
                'min:25'
            ],
            "gpa" => [
                'nullable',
                'numeric',
                'min:1',
                'max:4'
            ],
            "school-year" => [
                "nullable",
                'exists:school_years,school_year'
            ],
        ]);

        $validator->sometimes(['first-major','gpa','school-year'], 'required', function($input) use($currUser){
            return $currUser->is_tutor;
        });

        $validator->validate();

        // should only change the current user
        $currUser->firstMajor()->associate(Major::where('major', $request->input('first-major'))->first());
        $currUser->secondMajor()->associate(Major::where('major', $request->input('second-major'))->first());
        $currUser->minor()->associate(Minor::where('minor', $request->input('minor'))->first());
        $currUser->schoolYear()->associate(SchoolYear::where('school_year', $request->input('school-year'))->first());
        $currUser->gpa = $request->input('gpa');
        $currUser->introduction = $request->input('introduction');

        $currUser->save();

        if($currUser->is_invalid) {
            return redirect()->route('switch-account.index.register-to-be-tutor-2');
        }

        return redirect()->route('home.profile')->with('successMsg', 'Successfully updated your profile.');
    }

    public function updateHourlyRate(Request $request) {
        $request->validate([
            'hourly-rate' => [
                'required',
                'numeric',
                'min:10',
                'max:50'
            ]
        ]);

        Auth::user()->hourly_rate = $request->input('hourly-rate');
        Auth::user()->save();
    }

    public function getBookmarkSideBar(Request $request) {
        $view = view('home.partials.bookmarked-tutors--sidebar')->render();

        return response()->json([
            'view' => $view
        ]);
    }

}
