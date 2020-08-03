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

@include ('forum.partials.forum-helper-btn')

@include('forum.partials.report-modal')
@include('forum.partials.delete-post-modal')

<div class="container forum">
    <div class="row forum-row">
        @include("forum.partials.forum-left")
        <section class="col-12 col-md-9 col-lg-55-p forum-content">
            <div class="forum-heading-img"></div>

            @include('forum.partials.search')

            <div class="post-detail-container">
                <div class="post-detail">
                    @can('delete', $post)
                    <span class="post-detail-tag text-danger">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                          </svg>
                          <span class="status">Delete</span>
                    </span>
                    @endcan

                    <h4 class="post__heading fc-black-post-2">
                        {{ $post->title }}
                    </h4>
                    <p class="post__heading-2 mb-4 mt-3">
                        <span class="mr-3 fc-black-post">Posted By</span>
                        <img src="{{ Storage::url($post->user->profile_pic_url) }}" alt="user photo" class="poster-img">
                        @if (!Auth::check() || (Auth::check() && $post->user->id != Auth::user()->id))
                        <a href="#" class="poster-name mr-3">
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
                            {{ App\CustomClass\NumberFormatter::thousandsFormat($post->view_count) }}
                        </span>
                    </p>
                    <div class="post__content fs-1-6 mb-3">
                        {!! $post->content !!}
                    </div>

                    <div class="post__bottom">
                        <div class="tags fs-1-4">
                            @foreach ($post->tags as $tag)
                                <a class="tag"
                                    href="{{ route('posts.search', [
                                        'search-by' => 'tags',
                                        'tags' => [
                                            $tag->id
                                        ]
                                    ]) }}"
                                >{{ $tag->tag }}</a>
                            @endforeach
                        </div>
                        <div class="post__bottom__actions d-flex justify-content-end">
                            <div class="left-container d-flex align-items-center mt-2" data-post-slug="{{ $post->slug }}">
                                <div class="action action-upvote @if(Auth::check() && $post->upvotedBy(Auth::user())) active @endif">
                                    <svg class="mr-2px">
                                        <use xlink:href="{{asset('assets/sprite.svg#icon-thumbs-up')}}"></use>
                                    </svg>
                                    <span class="num">
                                        {{ $post->users_upvoted_count }}
                                    </span>
                                </div>

                                <div class="action action-reply @if(Auth::check() && $post->repliedBy(Auth::user())) active @endif" data-toggle="tooltip" data-placement="top" title="Reply">
                                    <svg class="mr-2px">
                                        <use xlink:href="{{asset('assets/sprite.svg#icon-bubbles')}}"></use>
                                    </svg>
                                    <span class="num">
                                        {{ $post->replies_count }}
                                    </span>
                                </div>

                                @can('follow', $post)
                                    @if(Auth::check() && $post->followedBy(Auth::user()))
                                    <div class="action action-follow active">
                                        <svg class="mr-3px">
                                            <use xlink:href="{{asset('assets/sprite.svg#icon-heart-full')}}"></use>
                                        </svg>
                                        <span class="text">
                                            Unfollow
                                        </span>
                                    </div>
                                    @else
                                    <div class="action action-follow">
                                        <svg class="mr-3px">
                                            <use xlink:href="{{asset('assets/sprite.svg#icon-heart-empty')}}"></use>
                                        </svg>
                                        <span class="text">
                                            Follow
                                        </span>
                                    </div>
                                    @endif
                                @endcan

                                <div class="action action-report mr-0">
                                    <svg class="mr-2px">
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
                    <div class="post-reply
                    @if ($post->bestReply && $reply->id == $post->bestReply->id)
                    best-reply
                    @endif
                    " data-reply-id="{{ $reply->id }}"
                    @if ($reply->id == session('newReplyId'))
                        id="scroll-to-reply"
                    @endif
                    >
                        @can('markAsBestReply', [$post, $reply])
                        <form action="{{ route('posts.markBestReply', [$post, $reply]) }}" class="mark-best-reply" method="POST">
                            @csrf
                            <svg>
                                <use xlink:href="{{asset('assets/sprite.svg#icon-star-empty')}}"></use>
                            </svg>
                            <button class="btn btn-link">Mark as Best Reply</button>
                        </form>
                        @endcan

                        @if ($post->bestReply && $reply->id == $post->bestReply->id)
                        <svg class="svg-best-reply" width="69" height="69" viewBox="0 0 69 69" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M42.7473 42.1417L35.4295 38.3413C34.8637 38.0177 34.1358 38.0177 33.5699 38.3413L26.2521 42.1417C25.484 42.5054 25.0795 43.3546 25.201 44.2036L28.3949 66.979H40.6047L43.7986 44.2037C43.92 43.3546 43.5155 42.5054 42.7473 42.1417Z" fill="#FABE2C"/>
                            <path d="M40.6047 66.9788L43.7987 44.2035C43.9201 43.3544 43.5157 42.5053 42.7475 42.1416L35.4297 38.3412C35.147 38.1794 34.8232 38.0986 34.5 38.0986V66.9788H40.6047Z" fill="#FF9100"/>
                            <path d="M46.6289 69H22.3711C21.2538 69 20.3496 68.0959 20.3496 66.9785C20.3496 65.8612 21.2538 64.957 22.3711 64.957H46.6289C47.7462 64.957 48.6504 65.8612 48.6504 66.9785C48.6504 68.0959 47.7462 69 46.6289 69Z" fill="#646D73"/>
                            <path d="M34.5 69H46.6289C47.7462 69 48.6504 68.0959 48.6504 66.9785C48.6504 65.8612 47.7462 64.957 46.6289 64.957H34.5V69Z" fill="#474F54"/>
                            <path d="M48.3743 49.5614L34.5004 42.3993L20.6264 49.5614C19.9473 49.9147 19.126 49.8476 18.5101 49.3956C17.8943 48.9436 17.5823 48.1835 17.7087 47.4294L20.283 32.0511L9.14905 21.1047C8.6042 20.5678 8.40676 19.7702 8.64368 19.0417C8.8806 18.3131 9.50443 17.7803 10.2625 17.6657L25.7237 15.3146L32.6921 1.0285C33.3791 -0.34153 35.6216 -0.34153 36.3086 1.0285L43.2772 15.3146L58.7385 17.6657C59.4965 17.7803 60.1204 18.3133 60.3573 19.0417C60.5942 19.7701 60.3968 20.5676 59.8519 21.1047L48.718 32.0511L51.2921 47.4294C51.4186 48.1835 51.1066 48.9435 50.4907 49.3956C49.8747 49.8453 49.0552 49.911 48.3743 49.5614Z" fill="#FED843"/>
                            <path d="M48.374 49.5605C49.0548 49.9102 49.8743 49.8446 50.4902 49.3947C51.1061 48.9427 51.4181 48.1826 51.2917 47.4285L48.7174 32.0502L59.8513 21.1038C60.3961 20.5669 60.5936 19.7693 60.3567 19.0408C60.1197 18.3122 59.4959 17.7794 58.7379 17.6648L43.2766 15.3137L36.3083 1.02759C35.9648 0.342574 35.2325 0 34.5 0V42.3983L48.374 49.5605Z" fill="#FABE2C"/>
                            <path d="M37.7249 34.9442L34.4992 33.2681L31.2734 34.9442C30.5983 35.2916 29.7692 35.2344 29.1533 34.7863C28.5334 34.3362 28.2215 33.5742 28.3478 32.82L28.9401 29.2291L26.3541 26.6766C25.7912 26.1278 25.6191 25.3143 25.8487 24.6117C26.0856 23.8852 26.7134 23.3522 27.4714 23.2378L31.0643 22.6968L32.6909 19.4455C33.3779 18.0755 35.6204 18.0755 36.3075 19.4455L37.9341 22.6968L41.5269 23.2378C42.285 23.3523 42.9127 23.8853 43.1496 24.6117C43.3866 25.3401 43.193 26.1397 42.6443 26.6766L40.0583 29.2291L40.6506 32.82C40.777 33.5742 40.465 34.3362 39.8451 34.7863C39.2293 35.2325 38.4056 35.2984 37.7249 34.9442Z" fill="#FABE2C"/>
                            <path d="M37.7257 34.9443C38.4066 35.2984 39.2303 35.2325 39.8459 34.7863C40.4658 34.3362 40.7776 33.5742 40.6514 32.8201L40.0591 29.2291L42.6451 26.6767C43.1939 26.1398 43.3874 25.3402 43.1505 24.6118C42.9135 23.8853 42.2858 23.3523 41.5278 23.2379L37.9349 22.6969L36.3083 19.4456C35.9648 18.7605 35.2325 18.418 34.5 18.418V33.2682L37.7257 34.9443Z" fill="#FF9100"/>
                        </svg>
                        <span class="text-best-reply">Best Reply</span>
                        @endif

                        <div class="left-container">
                            <img class="" src="{{ Storage::url($reply->user->profile_pic_url) }}" alt="user photo">
                            @if (!Auth::check() || (Auth::check() && Auth::user()->id != $reply->user->id))
                            <a class="user-name user-info" href="#">
                                {{ $reply->user->first_name }}
                            </a>
                            <span class="user-info fc-grey mt-1">
                                {{ $reply->user->firstMajor->major ?? '' }}
                            </span>
                            @else
                            <span class="user-name user-info">
                                Me
                            </span>
                            @endif
                        </div>
                        <div class="right-container">
                            <div class="post-reply__content">
                                {{ $reply->reply_content }}
                            </div>
                            <div class="post-reply__actions" data-reply-id="{{ $reply->id }}">
                                <span class="mr-auto fs-1-2 fc-grey">{{ $reply->created_at }}</span>
                                @if ($reply->replies_count > 0)
                                    <button class="btn btn-link btn-toggle-follow-up mr-2" type="button">
                                        <span class="keyword">Display</span>
                                    {{ $reply->replies_count }} {{ $reply->replies_count == 1 ? 'followup' : 'followups' }}
                                </button>
                                @endif
                                <div class="action action-upvote @if(Auth::check() && !($reply->usersUpvoted->isEmpty())) active @endif">
                                    <svg class="mr-1px">
                                        <use xlink:href="{{asset('assets/sprite.svg#icon-thumbs-up')}}"></use>
                                    </svg>
                                    <span class="num">
                                        {{ $reply->users_upvoted_count }}
                                    </span>
                                </div>
                                <div class="action action-reply mr-4">
                                    <svg>
                                        <use xlink:href="{{asset('assets/sprite.svg#icon-bubbles')}}"></use>
                                    </svg>
                                </div>
                                <div class="action action-report mr-0">
                                    <svg class="mr-1px">
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
                        <div
                            class="followup-container hidden"
                            data-followup-for="{{ $reply->id }}"
                            @if ($followup->id == session('newFollowupId'))
                                id="scroll-to-followup"
                            @endif
                        >
                            <div class="followup__content">
                                @if (!Auth::check() || Auth::user()->id != $followup->reply->user->id)
                                <a class="followup-to" href="#">
                                    {{ '@' . $followup->reply->user->first_name }}
                                </a>
                                {{-- @else --}}
                                {{-- <span class="followup-to">
                                    @Me
                                </span> --}}
                                @endif
                                {{ $followup->reply_content }}
                            </div>
                            <div class="followup__info" data-reply-id="{{ $followup->id }}">
                                <div class="followup__info__left">
                                    <span class="mr-1">{{ $followup->created_at }}</span>
                                    <span class="mr-1">by</span>
                                    @if (!Auth::check() || Auth::user()->id != $followup->user->id)
                                    <a href="#" class="followup__user">
                                        {{ $followup->user->first_name }}
                                    </a>
                                    @else
                                    <span class="followup__user">
                                        Me
                                    </span>
                                    @endif
                                </div>
                                <div class="action action-upvote @if(Auth::check() && !($followup->usersUpvoted->isEmpty())) active @endif">
                                    <svg class="mr-1px">
                                        <use xlink:href="{{asset('assets/sprite.svg#icon-thumbs-up')}}"></use>
                                    </svg>
                                    <span class="num">
                                        {{ $followup->users_upvoted_count }}
                                    </span>
                                </div>
                                <div class="action action-reply mr-4">
                                    <svg>
                                        <use xlink:href="{{asset('assets/sprite.svg#icon-bubbles')}}"></use>
                                    </svg>
                                </div>
                                <div class="action action-report mr-0">
                                    <svg class="mr-1px">
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
                        <form action="{{ route('posts.followup.store', $followup->id) }}" method="POST" class="post-followup hidden" data-followup-for="{{ $reply->id }}">
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
                        $(this).find('svg').html(data.svg);
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
            else if($(this).hasClass('action-report')) {
                $('#report-for').val(`post: ${postSlug}`)
                $('#reportModal').modal('show');
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
            else if($(this).hasClass('action-report')) {
                $('#report-for').val(`reply: ${replyId}`)
                $('#reportModal').modal('show');
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
        $(`.post-followup[data-followup-for=${replyId}]`).addClass('hidden');
    }
    $(`.followup-container[data-followup-for=${replyId}]`).toggleClass('hidden');

});

@auth
$('.user-card .btn-chat').click(function() {
    alert('chat');
});

$('.user-card .btn-request').click(function() {
    alert('request');
});

$('.user-card .btn-invite').click(function() {
    $.ajax({
        type:'POST',
        url: "{{ route('invite-to-be-tutor', $post->user) }}",
        success: (data) => {
            toastr.success(data.successMsg);
        },
        error: function(error) {
            toastr.error('Something went wrong!');
            console.log(error);
        }
    });
});

@else
$('.user-card button').click(function() {
    $('.overlay-student').show();
});

$('.bookmark-svg').click(function() {
    $('.overlay-student').show();
})
@endauth

@error('report-reason')
$('#reportModal').modal('show');
@enderror

@if (session('newFollowupId'))
    $(`.followup-container[data-followup-for=${$('#scroll-to-followup').attr('data-followup-for')}]`).removeClass('hidden');

    let replyId = $('#scroll-to-followup').attr('data-followup-for');
    $(`.post-reply[data-reply-id=${replyId}]`).find('.post-reply__actions .keyword').html('Hide');

    $('html, body').animate({
        scrollTop: $('#scroll-to-followup').offset().top - $('.nav').height() - 500
    }, 1000);
@elseif(session('newReplyId'))
    $('html, body').animate({
        scrollTop: $('#scroll-to-reply').offset().top - $('.nav').height() - 500
    }, 1000);
@endif


@can('delete', $post)
$('.post-detail-tag').click(function() {
    $('#deleteModal').modal('show');
});

$('#deleteModal .btn-delete').click(function() {
    $.ajax({
        type:'DELETE',
        url: '{{ route('posts.destroy', $post) }}',
        success: (data) => {
            toastr.success(data.successMsg);
            setTimeout(function() {
                window.location.href = "{{ route('posts.index') }}";
            }, 1000);
        },
        error: function(error) {
            toastr.error('Something went wrong!');
            console.log(error);
        }
    });
})
@endcan



</script>
@endsection
