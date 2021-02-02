@extends('layouts.app')
@section('title', 'TutorSpace - Refund Policy')
@section('content')
<div class="d-flex flex-column" style="height: 100vh">
    <h1 class="my-5 text-center">TutorSpace Refund Policy</h1>
    <div style="flex: 1;">
        <iframe src="{{ asset('policies/refund-policy.pdf') }}" width="100%" height="100%">
        </iframe>
    </div>
</div>
@endsection
