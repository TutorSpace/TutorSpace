@extends('layouts.app')

@section('title', 'Forum')


@section('body-class')
bg-white-dark-4

@if(Auth::check() && Auth::user()->is_tutor)
bg-tutor
@else
bg-student
@endif

@endsection

@section('content')

@include('partials.nav')

@include ('forum/partials.forum-helper-btn')

<div class="container forum">
    <div class="row forum-row">
        @include("forum.partials.forum-left")
        <section class="col-12 col-md-8 forum-content">
            <div class="forum-heading-img"></div>

            <form action="" method="POST" class="forum-content__search">
                <a class="btn btn-lg btn-back" href="{{ App\CustomClass\URLManager::getBackURL(route('posts.index')) }}">
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

            <div class="post-detail">
                <h5 class="post__heading fc-black-post">
                    {{ $post->title }}
                </h5>
                <p class="post__heading-2 fc-black-post">
                    <span class="mr-3">Posted By</span>
                    <img src="{{ Storage::url(App\User::find($post->user_id)->profile_pic_url) }}" alt="user photo" class="poster-img">
                    <a href="#" class="poster-name mr-3 btn-link">
                        {{ "{$post->user->first_name} {$post->user->last_name}" }}
                    </a>
                    <span>{{ $post->created_at }}</span>
                </p>
                <div class="post__content mb-4">
                    {!! $post->content !!}
                </div>

                <div class="post__bottom">
                    <div class="tags">
                        @foreach ($post->tags->take(3) as $tag)
                            <span class="tag">{{ $tag->tag }}</span>
                        @endforeach
                        @php
                            $cnt = $post->tags->count();
                        @endphp
                        @if ($cnt > 3)
                            <span class="fc-grey">and {{ $cnt - 3 }} more...</span>
                        @endif
                    </div>
                    <div class="post__bottom__info d-flex fc-black-post">
                        <div class="left-container d-flex align-items-center mt-3">
                            <svg class="mr-1">
                                <use xlink:href="{{asset('assets/sprite.svg#icon-thumbs-up')}}"></use>
                            </svg>
                            <span class="mr-5">
                                {{ $post->like_count }} people found this post useful.
                            </span>
                            <svg class="mr-1">
                                <use xlink:href="{{asset('assets/sprite.svg#icon-eye')}}"></use>
                            </svg>
                            <span class="mr-5">
                                {{ $post->view_count }}
                            </span>
                            <svg class="mr-1">
                                <use xlink:href="{{asset('assets/sprite.svg#icon-bubbles')}}"></use>
                            </svg>
                            <span class="">
                                0
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        @include("forum.partials.forum-right")
    </div>
</div>



@include('partials.footer')

@endsection

@section('js')

@include('partials.nav-auth-js')
<script src="{{ asset('js/forum/forum.js') }}"></script>
<script src="{{ asset('js/forum/index.js') }}"></script>
@endsection
