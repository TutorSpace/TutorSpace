<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Major;
use App\Minor;
use App\Course;
use App\SchoolYear;
use Illuminate\Http\Request;

class AutoCompleteController extends Controller
{
    public function getData(Request $request) {
        $result = [];
        if($request->input('majors')) $result['majors'] = Major::pluck('major');
        if($request->input('minors')) $result['minors'] = Minor::pluck('minor');
        if($request->input('courses')) $result['courses'] = Course::pluck('course');
        if($request->input('tags')) $result['tags'] = Tag::pluck('tag');
        if($request->input('schoolYears')) $result['schoolYears'] = SchoolYear::pluck('school_year');

        return response()->json($result);
    }

    public function getMajors(Request $request) {
        return response()->json(Major::select('id', 'major AS text')->where('major', 'like', "%{$request->input('q')}%")->get());
    }

    public function getMinors(Request $request) {
        return response()->json(Minor::select('id', 'minor AS text')->where('minor', 'like', "%{$request->input('q')}%")->get());
    }

    public function getSchoolYears(Request $request) {
        return response()->json(SchoolYear::select('id', 'school_year AS text')->where('school_year', 'like', "%{$request->input('q')}%")->get());
    }

    public function getCourses(Request $request) {
        return response()->json(Course::select('id', 'course AS text')->where('course', 'like', "%{$request->input('q')}%")->get());
    }

    public function getTags(Request $request) {
        return response()->json(Tag::select('id', 'tag AS text')->where('tag', 'like', "%{$request->input('q')}%")->get());
    }

}
