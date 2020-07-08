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
        <section class="col-12 col-md-9 col-lg-7 forum-content">
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
                <select name="" class="forum-content__search__sort-by ml-auto">
                    <option value="latest">Latest First</option>
                    <option value="popular">Popular First</option>
                </select>
            </form>

            <div class="post-previews">
                @foreach ($posts as $post)
                <div class="post-preview flex-wrap">
                    <div class="post-preview__left">
                        <h5>
                            <a class="post__heading fc-black-post"  href="{{ route('posts.show', $post->slug) }}">
                                {{ $post->title }}
                            </a>
                        </h5>
                        <p class="post__heading-2 fc-black-post">
                            <span class="mr-3">Posted By</span>
                            <img src="{{ Storage::url(App\User::find($post->user_id)->profile_pic_url) }}" alt="user photo" class="poster-img">
                            <a href="#" class="poster-name mr-3 btn-link">
                                {{ "{$post->user->first_name} {$post->user->last_name}" }}
                            </a>
                            <span>{{ $post->getTimeAgo() }}</span>
                        </p>
                        <div class="post__content fc-grey mb-4">
                            {!! Str::words(strip_tags($post->content), 30, ' ...') !!}
                        </div>
                    </div>
                    @if(!empty($post->getThumbNail()))
                        <div class="post-preview__right">
                            <img class="post-preview__right__thumbnail" src="{{ $post->getThumbNail()[1] }}" alt="thumbnail">
                        </div>
                    @endif
                    <div class="post__bottom">
                        <div class="tags">
                            @foreach ($post->tags->take(3) as $tag)
                                <span class="tag">{{ $tag->tag }}</span>
                            @endforeach
                            @php
                                $cnt = $post->tags->count();
                            @endphp
                            @if ($cnt > 3)
                                <span class="fc-grey">and {{ $cnt - 3 }} more...</span>
                            @endif
                        </div>
                        <div class="post__bottom__info d-flex fc-black-post">
                            <div class="left-container d-flex align-items-center mt-3">
                                <svg class="mr-1">
                                    <use xlink:href="{{asset('assets/sprite.svg#icon-thumbs-up')}}"></use>
                                </svg>
                                <span class="mr-5">
                                    {{ $post->like_count }} people found this post useful.
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
                                    0
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
<script src="{{ asset('js/forum/index.js') }}"></script>
@endsection
