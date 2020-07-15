@extends('layouts.app')

@section('title', 'Forum - My Posts')


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
@include('forum.partials.delete-post-modal')

<div class="container forum">
    <div class="row forum-row">
        @include("forum.partials.forum-left")
        <section class="col-12 col-md-9 col-lg-55-p forum-content">
            <div class="forum-heading-img"></div>

            @include('forum.partials.search')

            <div class="post-previews">
                @include('forum.partials.post-preview-my-posts')
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
    let postSlug, postPreview;

    $('.post-preview-tag').click(function() {
        $('#deleteModal').modal('show');
        postSlug = $(this).closest('.post-preview').attr('data-post-slug');
        postPreview = $(this).closest('.post-preview');
    });

    $('#deleteModal .btn-delete').click(function() {
        $.ajax({
            type:'DELETE',
            url: '/forum/posts/' + postSlug,
            success: (data) => {
                $('#deleteModal').modal('hide');
                postPreview.remove();
                toastr.success(data.successMsg);
            },
            error: function(error) {
                toastr.error('Something went wrong!');
                console.log(error);
            }
        });
    });


</script>
@endsection


