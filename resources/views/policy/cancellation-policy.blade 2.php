@extends('layouts.app')
@section('title', 'TutorSpace - Cancellation Policy')
@section('content')
<div class="d-flex flex-column" style="height: 100vh">
    <h1 class="my-5 text-center">TutorSpace Cancellation Policy</h1>
    <div style="flex: 1;">
        <iframe src="{{ asset('policies/cancellation-policy.pdf') }}" width="100%" height="100%">
        </iframe>
    </div>
</div>
@endsection
