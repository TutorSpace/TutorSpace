<?php

namespace App\Http\Controllers;

class SupportController extends Controller
{
    public function __construct() {

    }

    public function index() {
        return view('support.index');
    }
}
