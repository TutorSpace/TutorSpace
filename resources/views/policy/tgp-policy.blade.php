@extends('layouts.app')
@section('title', 'TutorSpace - Tutor Growth Plan')
@section('content')
<div class="d-flex flex-column" style="height: 100vh">
    <h1 class="my-5 text-center">TutorSpace Tutor Growth Plan</h1>
    <div style="flex: 1;">
        <iframe src="{{ asset('policies/TGP.pdf') }}" width="100%" height="100%">
        </iframe>
    </div>
</div>
@endsection
