@extends('layouts.app')
@section('title', 'TutorSpace - Tutor Verification Policy')
@section('content')
<div class="d-flex flex-column" style="height: 100vh">
    <h1 class="my-5 text-center">TutorSpace Tutor Verification Policy</h1>
    <div style="flex: 1;">
        <iframe src="{{ asset('policies/tutor-verification-policy.pdf') }}" width="100%" height="100%">
        </iframe>
    </div>
</div>
@endsection
