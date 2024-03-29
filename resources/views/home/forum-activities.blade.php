@extends('layouts.app')

@section('title', 'Dashboard - Forum Activities')

@section('body-class')
bg-white-dark-4

@if(Auth::check() && Auth::user()->is_tutor)
bg-tutor
@else
bg-student
@endif

@endsection

@section('links-in-head')

{{-- plotly --}}
<script src="{{ asset('vendor/plotly/plotly.js') }}"></script>
@endsection

@section('content')

@include('partials.nav')

@include('forum.partials.delete-post-modal')

<div class="container-fluid home p-relative">
    @include('home.partials.menu_bar')
    <main class="home__content">
        <div class="container col-layout-2 home__header-container">
            <div class="heading-container">
                <p class="heading">Forum Activities</p>
                <span>
                    View your statistics and track your participation in the TutorSpace forum.
                </span>
            </div>
        </div>

        <div class="container col-layout-2">
            <div class="row">
                <h5 class="mb-2 w-100">User Statistics</h5>
                <div class="home__data-visualizations">
                <div class="graph-1 graph-1{{Auth::user()->is_tutor == 1 ? "--tutor":""}}">
                        <div id="scatter-chart"></div>
                    </div>
                    @if(Auth::user()->is_tutor == 1)
                    <div class="graph-2">
                        <canvas id="rating-chart" class="rating-chart"></canvas>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="container col-layout-2">
            <div class="row forum mt-0">
                <h5 class="w-100 heading__forum-activities">
                    <span class="active">My Posts</span>
                    <span class="">My Follows</span>
                </h5>
                <div class="col-12 col-md-8 post-previews px-0">
                    <div>
                        @include('forum.partials.post-preview-my-posts', [
                            'posts' => $myPosts
                        ])
                    </div>

                    <div class="hidden-2">
                        @include('forum.partials.post-preview-my-follows', [
                            'posts' => $myFollows
                        ])
                    </div>
                </div>
                <div class="col-12 col-md-4 forum-data-container">
                    <div class="forum-data" id="forum-data-my-posts">
                        {{-- <svg class="notification-indicator" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="7.5" cy="7.5" r="7.5" fill="#FFBC00"/>
                        </svg> --}}
                        <span class="title">My Posts</span>
                        <a class="number" href="{{ route('posts.my-posts') }}">{{ Auth::user()->posts()->count() }}</a>
                    </div>
                    <div class="forum-data">
                        <span class="title">Participated</span>
                        <a class="number" href="{{ route('posts.my-participated') }}">{{ Auth::user()->participatedPosts()->get()->count() }}</a>
                    </div>
                    <div class="forum-data" id="forum-data-my-follows">
                        <span class="title">Followed</span>
                        <a class="number" href="{{ route('posts.my-follows') }}">{{ Auth::user()->followedPosts()->count() }}</a>
                    </div>
                </div>
            </div>
        </div>

    </main>

</div>


@endsection

@section('js')

<script>
let storageUrl = "{{ Storage::url('') }}";
</script>


{{-- for data visualization --}}
@include('home.partials.data-visualization')

<script>
    $('.heading__forum-activities span').click(function() {
        if(!$(this).hasClass('active')) {
            $(this).closest('.heading__forum-activities').find('.active').removeClass('active');
            $(this).addClass('active');

            $(this).closest('.forum').find('.post-previews > div').toggle();
        }
    });

    $('.post-preview-tag').click(function() {
        if($('.heading__forum-activities span.active').html() == 'My Posts') {
            $('#deleteModal').modal('show');
            postSlug = $(this).closest('.post-preview').attr('data-post-slug');
            postPreview = $(this).closest('.post-preview');
        }
        else {
            let postSlug = $(this).closest('.post-preview').attr('data-post-slug');
            JsLoadingOverlay.show(jsLoadingOverlayOptions);
            $.ajax({
                type:'POST',
                url: "{{ url('forum/posts/follow') }}" + `/${postSlug}`,
                success: (data) => {
                    $(this).closest('.post-preview').remove();
                    let num = parseInt($('#forum-data-my-follows .number').html());
                    $('#forum-data-my-follows .number').html(num - 1);
                    toastr.success('Successfully unfollowed the post.');
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                },
                error: function(error) {
                    toastr.error('Something went wrong!');
                    console.log(error);
                },
                complete: () => {
                    JsLoadingOverlay.hide()
                }
            });
        }
    });


    $('#deleteModal .btn-delete').click(function() {
        JsLoadingOverlay.show(jsLoadingOverlayOptions);
        $.ajax({
            type:'DELETE',
            url: '/forum/posts/' + postSlug,
            success: (data) => {
                $('#deleteModal').modal('hide');
                postPreview.remove();
                let num = parseInt($('#forum-data-my-posts .number').html());
                $('#forum-data-my-posts .number').html(num - 1);
                toastr.success(data.successMsg);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            },
            error: function(error) {
                toastr.error('Something went wrong!');
                console.log(error);
            },
            complete: () => {
                JsLoadingOverlay.hide();
            }
        });
    });
</script>

<script src="{{ asset('js/home/index.js') }}"></script>
@endsection
