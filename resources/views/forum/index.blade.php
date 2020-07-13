@extends('layouts.app')

@section('title', $pageTitle)


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
        <section class="col-12 col-md-9 col-lg-55-p forum-content">
            <div class="forum-heading-img"></div>

            @include('forum.partials.search')

            <div class="post-previews">
                @foreach ($posts as $post)
                <div class="post-preview flex-wrap">
                    <div class="post-preview__left">
                        <h5>
                            <a class="post__heading"  href="{{ route('posts.show', $post->slug) }}">
                                {{ $post->title }}
                            </a>
                        </h5>
                        <p class="post__heading-2">
                            <span class="mr-3">Posted By</span>
                            <img src="{{ Storage::url($post->user->profile_pic_url) }}" alt="user photo" class="poster-img">
                            @if (!Auth::check() || (Auth::check() && $post->user->id != Auth::user()->id))
                            <a href="#" class="poster-name mr-3 btn-link">
                                {{ "{$post->user->first_name} {$post->user->last_name}" }}
                            </a>
                            @else
                            <span class="poster-name mr-3">
                                Me
                            </span>
                            @endif
                            <span>{{ $post->getTimeAgo() }}</span>
                        </p>
                        <div class="post__content fc-grey mb-4">
                            {!! Str::words(strip_tags($post->content), 30, ' ...') !!}
                        </div>
                    </div>
                    @if($post->thumbNail)
                        <div class="post-preview__right">
                            <img class="post-preview__right__thumbnail" src="{{ $post->thumbNail }}" alt="thumbnail">
                        </div>
                    @endif
                    <div class="post__bottom">
                        <div class="tags">
                            @foreach ($post->tags->take(3) as $tag)
                                <span class="tag">{{ $tag->tag }}</span>
                            @endforeach
                            @if ($post->tags_count > 3)
                                <span class="fc-grey">and {{ $post->tags_count - 3 }} more...</span>
                            @endif
                        </div>
                        <div class="post__bottom__info d-flex">
                            <div class="left-container d-flex align-items-center mt-3">
                                <svg class="mr-1">
                                    <use xlink:href="{{asset('assets/sprite.svg#icon-thumbs-up')}}"></use>
                                </svg>
                                <span class="mr-5">
                                    {{ $post->users_upvoted_count }} people found this post useful.
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
                                    {{ $post->replies_count }}
                                </span>
                            </div>
                            <a href="{{ route('posts.show', $post->slug) }}" class="btn-link mt-3">View</a>
                        </div>
                    </div>
                </div>
                @endforeach

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
