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

<div class="container-fluid forum">
    <div class="row px-5">
        @include("forum.partials.forum-left")
        <section class="col-12 col-md-9 col-lg-7 forum-content">
            <div class="forum-heading-img"></div>

            <form action="" method="POST" class="forum-content__search">
                <a class="btn btn-lg btn-back" href="{{ App\CustomClass\URLManager::getBackURL(route('posts.index')) }}">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                    </svg>
                    Back
                </a>
                <select name="" class="forum-content__search__sort-by ml-auto">
                    <option value="popular">Popular First</option>
                    <option value="latest">Latest First</option>
                </select>
            </form>

            <div class="discussion-previews">
                <div class="discussion-preview flex-wrap">
                    <span class="discussion-preview-tag">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-heart-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                        </svg>
                        Followed
                    </span>
                    <div class="discussion-preview__left">
                        <h5>
                            <a class="discussion__heading fc-black-post"  href="#">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur adipisci quasi atque non at quia? Quia tempora fugiat illo voluptas molestias officiis nemo cum neque, architecto reiciendis placeat commodi quaerat!
                            </a>
                        </h5>
                        <p class="discussion__heading-2 fc-black-post">
                            <span class="mr-3">Posted By</span>
                            <img src="{{asset('assets/images/usc.jpg')}}" alt="user photo" class="poster-img">
                            <a href="#" class="poster-name mr-3 btn-link">Nemo Enim</a>
                            <span>Three days ago</span>
                        </p>
                        <p class="discussion__content fc-grey">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facilis quidem Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facilis quidem
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facilis quidem
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facilis quidemLorem ipsum dolor sit amet consectetur, adipisicing elit. Facilis quidemLorem ipsum dolor sit amet consectetur, adipisicing elit. Facilis quidemLorem ipsum dolor sit amet consectetur, adipisicing elit. Facilis quidem
                        </p>
                    </div>
                    <div class="discussion-preview__right">
                        <img class="discussion-preview__right__thumbnail" src="{{asset('assets/images/usc.jpg')}}" alt="thumbnail">
                    </div>
                    <div class="discussion__bottom">
                        <div class="tags">
                            <span class="tag">Computer Science</span>
                            <span class="tag">Computer</span>
                            <span class="tag">Science</span>
                            <span class="fc-grey">and 5 more...</span>
                        </div>
                        <div class="discussion__bottom__info d-flex fc-black-post">
                            <div class="left-container d-flex align-items-center mt-3">
                                <svg class=" mr-1">
                                    <use xlink:href="{{asset('assets/sprite.svg#icon-search')}}"></use>
                                </svg>
                                <span class="mr-5">
                                    105 people found this post useful.
                                </span>
                                <svg class=" mr-1">
                                    <use xlink:href="{{asset('assets/sprite.svg#icon-search')}}"></use>
                                </svg>
                                <span class="mr-5">
                                    439
                                </span>
                                <svg class=" mr-1">
                                    <use xlink:href="{{asset('assets/sprite.svg#icon-search')}}"></use>
                                </svg>
                                <span class="">
                                    97
                                </span>
                            </div>
                            <a href="#" class="mt-3 btn-link">View</a>
                        </div>
                    </div>
                </div>
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
