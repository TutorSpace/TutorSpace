@forelse ($posts as $post)
<div class="post-preview" data-post-slug="{{ $post->slug }}">
    <span class="post-preview-tag text-danger">
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
        </svg>
        <span class="status">Delete</span>
    </span>
    <div class="post__heading-2">
        @if (Illuminate\Support\Str::of($post->user->profile_pic_url)->contains('placeholder'))
        <div class="poster-img placeholder-img">
            <span>{{ strtoupper($post->user->first_name[0]) . ' ' . strtoupper($post->user->last_name[0]) }}</span>
        </div>
        @else
        <img src="{{ Storage::url($post->user->profile_pic_url) }}" alt="user photo" class="poster-img">
        @endif
        <span class="poster-name mr-2">
            Me
        </span>
        <span class="mr-2 fw-900">&middot;</span>
        <span>{{ $post->getTimeAgo() }}</span>
    </div>

    <div class="post-preview__content-container">
        <div class="post-preview__left">
            <h5 class="mb-2">
                <a class="post__heading"  href="{{ route('posts.show', $post->slug) }}">
                    {{ $post->title }}
                </a>
            </h5>
            <div class="post__content fc-grey mb-2">
                {{ strip_tags($post->content) }}
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
                    <span class="tag" style="background-color: {{ $tag->color }}; color: white;">{{ $tag->tag }}</span>
                @endforeach
                @if ($post->tags_count > 3)
                    <span class="fc-grey">and {{ $post->tags_count - 3 }} more...</span>
                @endif
            </div>
            <div class="post__bottom__info d-flex">
                <div class="left-container d-flex align-items-center">
                    <svg class="mr-6px">
                        <use xlink:href="{{asset('assets/sprite.svg#icon-thumbs-up')}}"></use>
                    </svg>
                    <span class="mr-5">
                        {{ $post->users_upvoted_count }} people liked this post.
                    </span>
                    <svg class="mr-6px">
                        <use xlink:href="{{asset('assets/sprite.svg#icon-eye')}}"></use>
                    </svg>
                    <span class="mr-5">
                        {{ App\CustomClass\NumberFormatter::thousandsFormat($post->view_count) }}
                    </span>
                    <svg class="mr-6px">
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

</div>
@empty
<h5 class="no-posts">You have not posted any posts yet.</h5>
@endforelse
