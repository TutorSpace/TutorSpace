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

            <form action="" method="POST" class="forum-content__search">
                <div class="form-search">
                    <input type="text" class="form-control form-control-lg input-search" placeholder="Computer Science...">
                    <svg class="svg-search">
                        <use xlink:href="{{asset('assets/sprite.svg#icon-search')}}"></use>
                    </svg>
                </div>
                <select name="" class="forum-content__search__search-by">
                    <option value="tags">Search by Tags</option>
                    <option value="keywords">Search by Keywords</option>
                </select>
                {{-- <select name="" class="forum-content__search__type-by">
                    <option value="tags">Both</option>
                    <option value="tags">Questions Only</option>
                    <option value="keywords">Discussions Only</option>
                </select> --}}
            </form>

            <div class="post-previews">
                @foreach ($posts as $post)
                <div class="post-preview flex-wrap" data-post-slug="{{ $post->slug }}">
                    <span class="post-preview-tag text-danger">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                          </svg>
                          <span class="status">Delete</span>
                    </span>
                    <div class="post-preview__left">
                        <h5>
                            <a class="post__heading"  href="{{ route('posts.show', $post->slug) }}">
                                {{ $post->title }}
                            </a>
                        </h5>
                        <p class="post__heading-2">
                            <span class="mr-3">Posted By</span>
                            <img src="{{ Storage::url($post->user->profile_pic_url) }}" alt="user photo" class="poster-img">
                            <span class="poster-name mr-3">
                                Me
                            </span>
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


