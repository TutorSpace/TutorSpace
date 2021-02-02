@extends('layouts.app')
@section('title', 'TutorSpace - Service Agreement')
@section('content')
<div class="d-flex flex-column" style="height: 100vh">
    <h1 class="my-5 text-center">TutorSpace Service Agreement</h1>
    <div style="flex: 1;">
        <iframe src="{{ asset('policies/service-agreement.pdf') }}" width="100%" height="100%">
        </iframe>
    </div>
</div>
@endsection
