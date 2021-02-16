@extends('layouts.app')

@section('title', 'Test')

@section('body-class')
bg-white-dark-4

@if(Auth::check() && Auth::user()->is_tutor)
bg-tutor
@else
bg-student
@endif

@endsection

@section('links-in-head')


@section('content')

@include('partials.nav')



@endsection

@section('js')

<script>

    getOnboarding(1);

</script>

@endsection
