@extends('layouts.app')

@section('title', 'Forum - My Follows')


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

<div class="container forum">
    <div class="row forum-row">
        @include("forum.partials.forum-left")
        <section class="col-12 col-md-9 col-lg-55-p forum-content">
            <div class="forum-heading-img"></div>

            @include('forum.partials.search')

            <div class="post-previews">
                @include('forum.partials.post-preview-my-follows')
                {{ $posts->withQueryString()->links() }}
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
    $('.post-preview-tag').click(function() {
        let postSlug = $(this).closest('.post-preview').attr('data-post-slug');
        JsLoadingOverlay.show(jsLoadingOverlayOptions);
        $.ajax({
            type:'POST',
            url: 'follow/' + postSlug,
            success: (data) => {
                $(this).closest('.post-preview').remove();
                toastr.success('Successfully unfollowed the post.');
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
@endsection


