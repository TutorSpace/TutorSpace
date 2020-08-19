@forelse ($posts as $post)
<div class="post-preview @if(Auth::check() && $post->user->id == Auth::user()->id) post-preview--mypost @endif">
    <p class="post__heading-2">
        <img src="{{ Storage::url($post->user->profile_pic_url) }}" alt="user photo" class="poster-img">
        @if (!Auth::check() || (Auth::check() && $post->user->id != Auth::user()->id))
        <a href="#" class="poster-name mr-2">
            {{ "{$post->user->first_name} {$post->user->last_name}" }}
        </a>
        @else
        <span class="poster-name mr-2">
            Me
        </span>
        @endif
        <span class="mr-2 fw-900">&middot;</span>
        <span>{{ $post->getTimeAgo() }}</span>
    </p>

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
                    <span class="tag">{{ $tag->tag }}</span>
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
<h5 class="mt-4">No posts yet.</h5>
@endforelse
