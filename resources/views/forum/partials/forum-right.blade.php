@php
    $tz = App\CustomClass\TimeFormatter::getTZ();
@endphp

<section class="col-3 forum-right">
    <a class="btn btn-lg btn-add-post btn-animation-y" href="#">
        <svg class="mr-2" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5H4a.5.5 0 0 1 0-1h3.5V4a.5.5 0 0 1 .5-.5z"/>
            <path fill-rule="evenodd" d="M7.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0V8z"/>
        </svg>
        Add A New Post
    </a>

    <section class="trending-tags">
        <h6 class="trending-tags__heading">
            <svg class="svg-trending-tag mr-1">
                <use xlink:href="{{asset('assets/sprite.svg#icon-stars')}}"></use>
            </svg>
            Trending Tags
        </h6>

        <table class="trending-tags__list table">
            <thead>
                <tr>
                    <th scope="col">&nbsp;Tag</th>
                    <th scope="col">Post</th>
                    <th scope="col">Reply</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($trendingTags as $trendingTag)
                <tr class="trending-tags__list-item mb-3">
                    <th>
                        <a class="tag-name"
                            href="{{ route('posts.search', [
                            'search-by' => 'tags',
                            'tags' => [
                                $trendingTag->id
                            ]
                        ]) }}">#{{ $trendingTag->tag }}</a>
                    </th>
                    <td class="post-cnt">{{ $trendingTag->posts_count }}</td>
                    <td class="reply-cnt">{{ $trendingTag->replies_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p class="fs-1-2 bottom-0 right-0 fc-grey my-0 text-right">
            Last Updated at {{ cache('TAGS.TRENDING-TAGS-UPDATE-TIME')->setTimeZone($tz) }}
        </p>
    </section>

    <div class="forum-heading-img forum-heading-img--right mt-5"></div>

    <div class="you-may-help-with">
        <h6 class="you-may-help-with__heading">
            <svg class="svg-help mr-2">
                <use xlink:href="{{asset('assets/sprite.svg#icon-help')}}"></use>
            </svg>
            You may help with...
        </h6>
        <div class="questions">
            @foreach ($youMayHelpWithPosts as $post)
            <a href="{{ route('posts.show', $post->slug) }}" class="question">
                {{ $post->title }}
            </a>
            @endforeach
            <p class="fs-1-2 bottom-0 right-0 fc-grey mb-0 mt-4 text-right">
                @auth
                Last Updated at {{ cache('POSTS.YOU-MAY-HELP-WITH-UPDATE-TIME.' . Str::upper(Auth::user()->email))->setTimeZone($tz) }}
                @else
                Last Updated at {{ cache('POSTS.YOU-MAY-HELP-WITH-UPDATE-TIME')->setTimeZone($tz) }}
                @endauth
            </p>
        </div>
    </div>
</section>
