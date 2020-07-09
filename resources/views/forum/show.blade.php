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
        <section class="col-12 col-md-9 col-lg-55-p forum-content">
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

            <div class="post-detail-container">
                <div class="post-detail">
                    <h4 class="post__heading">
                        {{ $post->title }}
                    </h4>
                    <p class="post__heading-2 mb-4">
                        <span class="mr-3">Posted By</span>
                        <img src="{{ Storage::url(App\User::find($post->user_id)->profile_pic_url) }}" alt="user photo" class="poster-img">
                        @can('viewProfile', $post)
                        <a href="#" class="poster-name mr-3 btn-link">
                            {{ "{$post->user->first_name} {$post->user->last_name}" }}
                        </a>
                        @else
                        <span class="poster-name mr-3">
                            Me
                        </span>
                        @endcan
                        <span class="mr-4">{{ $post->getTime() }}</span>
                        <svg class="mr-1">
                            <use xlink:href="{{asset('assets/sprite.svg#icon-eye')}}"></use>
                        </svg>
                        <span>
                            {{ $post->view_count }}
                        </span>
                    </p>
                    <div class="post__content mb-4">
                        {!! $post->content !!}
                    </div>

                    <div class="post__bottom">
                        <div class="tags">
                            @foreach ($post->tags as $tag)
                                <span class="tag">{{ $tag->tag }}</span>
                            @endforeach
                        </div>
                        <div class="post__bottom__actions d-flex mt-3 justify-content-end">
                            <div class="left-container d-flex align-items-center mt-3">
                                <div class="action action-useful">
                                    <svg>
                                        <use xlink:href="{{asset('assets/sprite.svg#icon-thumbs-up')}}"></use>
                                    </svg>
                                    <span>
                                        {{ $post->like_count }}
                                    </span>
                                </div>

                                <div class="action action-reply">
                                    <svg>
                                        <use xlink:href="{{asset('assets/sprite.svg#icon-bubbles')}}"></use>
                                    </svg>
                                    <span>
                                        {{ $post->replies->count() }}
                                    </span>
                                </div>

                                <div class="action action-follow">
                                    <svg>
                                        <use xlink:href="{{asset('assets/sprite.svg#icon-heart')}}"></use>
                                    </svg>
                                    <span>
                                        Follow
                                    </span>
                                </div>

                                <div class="action action-report mr-0">
                                    <svg>
                                        <use xlink:href="{{asset('assets/sprite.svg#icon-warning')}}"></use>
                                    </svg>
                                    <span>
                                        Report
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="post-reply">
                    <div class="left-container">
                        <img src="https://storage.googleapis.com/tutorspace-storage/user-profile-photos/4IZ41ITmkNX5Sf1kaEJsIGmYh5YwFHQEaNQQ1rP0.png" alt="user photo">
                        <a class="user-name user-info" href="#">User Name dfgsdhg</a>
                        <span class="user-info">Business Administration</span>
                    </div>
                    <div class="right-container">
                        <div class="post-reply__content">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Harum, neque. Cumque labore ullam facilis voluptatum, porro aperiam voluptate earum quo tenetur reiciendis maiores incidunt beatae numquam quasi eligendi temporibus quis. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Harum, neque. Cumque labore ullam facilis voluptatum, porro aperiam voluptate earum quo tenetur reiciendis maiores incidunt beatae numquam quasi eligendi temporibus quis. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Harum, neque. Cumque labore ullam facilis voluptatum, porro aperiam voluptate earum quo tenetur reiciendis maiores incidunt beatae numquam quasi eligendi temporibus quis.
                        </div>
                        <div class="post-reply__actions">
                            <span class="mr-auto fs-1-2">reply time</span>
                            <button class="btn btn-link btn-toggle-follow-up mr-2">Hide all followups</button>
                            <div class="action action-useful">
                                <svg>
                                    <use xlink:href="{{asset('assets/sprite.svg#icon-thumbs-up')}}"></use>
                                </svg>
                                <span>
                                    13
                                </span>
                            </div>
                            <div class="action action-reply">
                                <svg>
                                    <use xlink:href="{{asset('assets/sprite.svg#icon-bubbles')}}"></use>
                                </svg>
                                <span>
                                    13
                                </span>
                            </div>
                            <div class="action action-report mr-0">
                                <svg>
                                    <use xlink:href="{{asset('assets/sprite.svg#icon-warning')}}"></use>
                                </svg>
                                <span>
                                    Report
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="post-comment">
                    <img src="https://storage.googleapis.com/tutorspace-storage/user-profile-photos/4IZ41ITmkNX5Sf1kaEJsIGmYh5YwFHQEaNQQ1rP0.png" alt="user photo">
                    <textarea class="post-comment__input" placeholder="Add your comments here..." rows="2"></textarea>
                    <button class="btn btn-lg btn-reply">Reply</button>
                </div>

                <div class="followup-container">
                    <div class="followup__content">
                        <a class="followup-to" href="#">@Shuaiqing Luo</a>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt omnis odit suscipit esse nobis dolorum dolores iusto deleniti, minima aperiam commodi assumenda necessitatibus, ab, modi quas eaque harum non! Odio?
                    </div>
                    <div class="followup__info">
                        <div class="followup__info__left">
                            <span class="mr-1">Jan 07 2020 1:32pm</span>
                            <span class="mr-1">by</span>
                            <a href="#" class="followup__user">Donald Trump</a>
                        </div>
                        <div class="action action-useful">
                            <svg>
                                <use xlink:href="{{asset('assets/sprite.svg#icon-thumbs-up')}}"></use>
                            </svg>
                            <span>
                                2
                            </span>
                        </div>
                        <div class="action action-reply">
                            <svg>
                                <use xlink:href="{{asset('assets/sprite.svg#icon-bubbles')}}"></use>
                            </svg>
                            <span>
                                3
                            </span>
                        </div>
                        <div class="action action-report mr-0">
                            <svg>
                                <use xlink:href="{{asset('assets/sprite.svg#icon-warning')}}"></use>
                            </svg>
                            <span>
                                Report
                            </span>
                        </div>
                    </div>
                </div>
                <div class="post-followup">
                    <textarea class="post-followup__input" placeholder="Add your comments here..." rows="2"></textarea>
                    <button class="btn btn-lg btn-reply">Reply</button>
                </div>
                <div class="followup-container">
                    <div class="followup__content">
                        <a class="followup-to" href="#">@Shuaiqing Luo</a>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt omnis odit suscipit esse nobis dolorum dolores iusto deleniti, minima aperiam commodi assumenda necessitatibus, ab, modi quas eaque harum non! Odio?
                    </div>
                    <div class="followup__info">
                        <div class="followup__info__left">
                            <span class="mr-1">Jan 07 2020 1:32pm</span>
                            <span class="mr-1">by</span>
                            <a href="#" class="followup__user">Donald Trump</a>
                        </div>
                        <div class="action action-useful">
                            <svg>
                                <use xlink:href="{{asset('assets/sprite.svg#icon-thumbs-up')}}"></use>
                            </svg>
                            <span>
                                2
                            </span>
                        </div>
                        <div class="action action-reply">
                            <svg>
                                <use xlink:href="{{asset('assets/sprite.svg#icon-bubbles')}}"></use>
                            </svg>
                            <span>
                                3
                            </span>
                        </div>
                        <div class="action action-report mr-0">
                            <svg>
                                <use xlink:href="{{asset('assets/sprite.svg#icon-warning')}}"></use>
                            </svg>
                            <span>
                                Report
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
