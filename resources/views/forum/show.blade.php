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
                            <div class="left-container d-flex align-items-center mt-3" data-post-slug="{{ $post->slug }}">
                                <div class="action action-upvote @if(Auth::check() && $post->upvotedBy(Auth::user())) active @endif">
                                    <svg>
                                        <use xlink:href="{{asset('assets/sprite.svg#icon-thumbs-up')}}"></use>
                                    </svg>
                                    <span class="num">
                                        {{ $post->users_upvoted_count }}
                                    </span>
                                </div>

                                <div class="action action-reply @if(Auth::check() && $post->repliedBy(Auth::user())) active @endif">
                                    <svg>
                                        <use xlink:href="{{asset('assets/sprite.svg#icon-bubbles')}}"></use>
                                    </svg>
                                    <span class="num">
                                        {{ $post->replies_count }}
                                    </span>
                                </div>

                                @if(Auth::check() && $post->followedBy(Auth::user()))
                                <div class="action action-follow active">
                                    <svg>
                                        <use xlink:href="{{asset('assets/sprite.svg#icon-heart')}}"></use>
                                    </svg>
                                    <span class="text">
                                        Unfollow
                                    </span>
                                </div>
                                @else
                                <div class="action action-follow">
                                    <svg>
                                        <use xlink:href="{{asset('assets/sprite.svg#icon-heart')}}"></use>
                                    </svg>
                                    <span class="text">
                                        Follow
                                    </span>
                                </div>
                                @endif

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

                {{-- post comment --}}
                @auth
                <form action="{{ route('posts.reply.store', $post->slug) }}" method="POST" class="post-comment hidden">
                    @csrf
                    <img src="{{ Storage::url(Auth::user()->profile_pic_url) }}" alt="user photo">
                    <textarea class="post-comment__input" placeholder="Add your comments here..." rows="2" name="content"></textarea>
                    <button class="btn btn-lg btn-reply">Reply</button>
                </form>
                @endauth


                @foreach ($post->replies as $reply)
                <div class="post-reply" data-reply-id="{{ $reply->id }}">
                    <div class="left-container">
                        <img src="{{ Storage::url($reply->user->profile_pic_url) }}" alt="user photo">
                        @if (Auth::check() && Auth::user()->id != $reply->user->id)
                        <a class="user-name user-info" href="#">
                            {{ $reply->user->first_name . ' ' . $reply->user->last_name }}
                        </a>
                        @else
                        <span class="user-name user-info">
                            Me
                        </span>
                        @endif
                        <span class="user-info">
                            {{ $reply->user->firstMajor->major ?? 'None' }}
                        </span>
                    </div>
                    <div class="right-container">
                        <div class="post-reply__content">
                            {{ $reply->reply_content }}
                        </div>
                        <div class="post-reply__actions" data-reply-id="{{ $reply->id }}">
                            <span class="mr-auto fs-1-2">{{ $reply->created_at }}</span>
                            @if ($reply->replies_count > 0)
                                <button class="btn btn-link btn-toggle-follow-up mr-2" type="button"><span class="keyword">Display</span> all {{ $reply->replies_count }} followups</button>
                            @endif
                            <div class="action action-upvote @if(Auth::check() && !($reply->usersUpvoted->isEmpty())) active @endif">
                                <svg>
                                    <use xlink:href="{{asset('assets/sprite.svg#icon-thumbs-up')}}"></use>
                                </svg>
                                <span class="num">
                                    {{ $reply->users_upvoted_count }}
                                </span>
                            </div>
                            <div class="action action-reply @if(Auth::check() && !($reply->followups->isEmpty()))) active @endif @auth @cannot('followup', $reply) disabled @endcannot @endauth">
                                <svg>
                                    <use xlink:href="{{asset('assets/sprite.svg#icon-bubbles')}}"></use>
                                </svg>
                                <span class="num">
                                    {{ $reply->replies_count }}
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

                {{-- post followup of direct reply --}}
                @auth
                <form action="{{ route('posts.followup.store', $reply->id) }}" method="POST" class="post-comment hidden">
                    @csrf
                    <img src="{{ Storage::url(Auth::user()->profile_pic_url) }}" alt="user photo">
                    <textarea class="post-comment__input" placeholder="Add your comments here..." rows="2" name="content"></textarea>
                    <button class="btn btn-lg btn-reply">Reply</button>
                </form>
                @endauth

                    {{-- for followups --}}
                    @foreach ($reply->replies as $followup)
                        <div class="followup-container hidden" data-followup-for="{{ $reply->id }}">
                            <div class="followup__content">
                                @if (Auth::user()->id != $followup->reply->user->id)
                                <a class="followup-to" href="#">
                                    {{ '@' . $followup->reply->user->first_name }}
                                    {{ $followup->reply->user->last_name }}
                                </a>
                                @else
                                <span class="followup-to">
                                    {{ '@' . $followup->reply->user->first_name }}
                                    {{ $followup->reply->user->last_name }}
                                </span>
                                @endif
                                {{ $followup->reply_content }}
                            </div>
                            <div class="followup__info" data-reply-id="{{ $followup->id }}">
                                <div class="followup__info__left">
                                    <span class="mr-1">{{ $followup->created_at }}</span>
                                    <span class="mr-1">by</span>
                                    @if (Auth::user()->id != $followup->user->id)
                                    <a href="#" class="followup__user">
                                        {{ $followup->user->first_name }}
                                        {{ $followup->user->last_name }}
                                    </a>
                                    @else
                                    <span class="followup__user">
                                        Me
                                    </span>
                                    @endif
                                </div>
                                <div class="action action-upvote @if(Auth::check() && $followup->upvotedBy(Auth::user())) active @endif">
                                    <svg>
                                        <use xlink:href="{{asset('assets/sprite.svg#icon-thumbs-up')}}"></use>
                                    </svg>
                                    <span class="num">
                                        {{ $followup->usersUpvoted()->count() }}
                                    </span>
                                </div>
                                @can('followup', $followup)
                                <div class="action action-reply">
                                    <svg>
                                        <use xlink:href="{{asset('assets/sprite.svg#icon-bubbles')}}"></use>
                                    </svg>
                                </div>
                                @endcan
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

                        {{-- post followup of the followups --}}
                        @auth
                        <form action="{{ route('posts.followup.store', $followup->id) }}" method="POST" class="post-followup hidden">
                            @csrf
                            <textarea class="post-followup__input" placeholder="Add your comments here..." rows="2" name="content"></textarea>
                            <button class="btn btn-lg btn-reply">Reply</button>
                        </form>
                        @endauth
                    @endforeach

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

<script>
$('.action').click(function() {
    if($(this).hasClass('disabled')) {
        return;
    }

    @auth
        let postSlug = $(this).parent().attr('data-post-slug');
        let replyId = $(this).parent().attr('data-reply-id');

        // if for the post
        if(postSlug) {
            if($(this).hasClass('action-upvote')) {
                $.ajax({
                    type:'POST',
                    url: 'upvote/' + postSlug,
                    success: (data) => {
                        $(this).toggleClass('active');
                        $(this).find('.num').html(data.num);
                    },
                    error: function(error) {
                        toastr.error('Something went wrong!');
                        console.log(error);
                    }
                });
            }
            else if($(this).hasClass('action-follow')){
                $.ajax({
                    type:'POST',
                    url: 'follow/' + postSlug,
                    success: (data) => {
                        $(this).toggleClass('active');
                        $(this).find('.text').html(data.text);
                    },
                    error: function(error) {
                        toastr.error('Something went wrong!');
                        console.log(error);
                    }
                });
            }
            else if($(this).hasClass('action-reply')) {
                $(this).closest('.post-detail').next().toggleClass('hidden');
            }
        }
        // if for the replies
        else if(replyId) {
            if($(this).hasClass('action-upvote')) {
                let url = '{{ url('/forum/posts/replies') }}' + `/${replyId}/upvote`;
                $.ajax({
                    type:'POST',
                    url: url,
                    success: (data) => {
                        $(this).toggleClass('active');
                        $(this).find('.num').html(data.num);
                    },
                    error: function(error) {
                        toastr.error('Something went wrong!');
                        console.log(error);
                    }
                });
            }
            else if($(this).hasClass('action-reply')) {
                $(this).closest('.post-reply, .followup-container').next().toggleClass('hidden');
            }
        }
    @else
        $('.overlay-student').show();
    @endauth
})

$('.btn-toggle-follow-up').click(function() {
    let replyId = $(this).closest('.post-reply').attr('data-reply-id');
    if($(this).find('.keyword').html() == 'Display') {
        $(this).find('.keyword').html('Hide');
    }
    else {
        $(this).find('.keyword').html('Display');
    }
    $(`.followup-container[data-followup-for=${replyId}]`).toggleClass('hidden');
});

@auth
    $('.user-card button').click(function() {
        $('.overlay-student').show();
    });
@else
    $('.user-card .btn-chat').click(function() {
        alert('chat');
    });

    $('.user-card .btn-request').click(function() {
        alert('request');
    });

    $('.user-card .btn-invite').click(function() {
        alert('invite');
    });

@endauth




</script>
@endsection
