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
}
