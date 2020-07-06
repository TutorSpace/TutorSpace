@extends('layouts.app')

@section('title', 'Forum')

@section('links-in-head')

@endsection

@section('body-class')
bg-white-dark-4

@if(Auth::check() && Auth::user()->is_tutor)
bg-tutor select2-bg-tutor
@else
bg-student select2-bg-student
@endif

@endsection

@section('content')

@include('partials.nav')

@include ('forum/partials.forum-helper-btn')

<div class="container-fluid forum">
    <div class="row px-5">
        @include("forum.partials.forum-left")
        <section class="col-12 col-md-9 col-lg-7 forum-content">
            <div class="forum-heading-img"></div>

            <form action="" method="POST" class="forum-content__search">
                <a class="btn btn-lg btn-back" href="{{ URL::previous() }}">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                    </svg>
                    Back
                </a>
                <div class="form-search">
                    <input type="text" class="form-control form-control-lg input-search" placeholder="Computer Science...">
                    <svg class="svg-search">
                        <use xlink:href="{{asset('assets/sprite.svg#icon-search')}}"></use>
                    </svg>
                </div>
            </form>

            <form class="post-create" action="#" method="POST">
                <h5 class="font-weight-bold mb-5">Create a new post</h5>
                <p class="input-title">Post Type</p>
                <div class="input-content">
                    <button class="btn btn-lg btn-post-type" type="button">Questsion</button>
                    <button class="btn btn-lg btn-post-type" type="button">Discussion</button>
                </div>
                <p class="input-title">Title</p>
                <div class="input-content">
                    <input type="text" class="post-title" placeholder="Enter your post title here...">
                </div>
                <p class="input-title">Body</p>
                <div class="input-content">
                    <textarea name="" class="post-body"></textarea>
                </div>
                <p class="input-title">Tags</p>
                <div class="input-content">
                    <div class="input-group select-container p-relative select-container-icon pb-0-5">
                        <svg class="select-container__icon">
                            <use xlink:href="{{asset('assets/sprite.svg#icon-search')}}"></use>
                        </svg>
                        <select class="custom-select" name="courses[]" multiple="multiple" id="courses" required>
                            @foreach (App\Course::all() as $course)
                                <option value="{{ $course->id }}">{{ $course->course }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-prepend">
                            <svg>
                                <use xlink:href="{{asset('assets/sprite.svg#icon-keyboard_arrow_down')}}"></use>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-lg btn-save btn-animation-y">Save as Draft</button>
                    <button class="btn btn-lg btn-create btn-animation-y">Create Post</button>
                </div>

                @csrf
            </form>


        </section>

        @include("forum.partials.forum-right")
    </div>
</div>



@include('partials.footer')

@endsection

@section('js')

@include('partials.nav-auth-js')

<script src="{{ asset('js/forum/forum.js') }}"></script>
<script src="{{ asset('js/forum/create.js') }}"></script>
@endsection
