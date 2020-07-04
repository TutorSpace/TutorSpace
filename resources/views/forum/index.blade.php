@extends('layouts.app')

@section('title', 'Forum')

@section('body-class')
bg-grey-light

@if(Auth::check() && Auth::user()->is_tutor)
bg-tutor
@else
bg-student
@endif

@endsection

@section('content')

@include('partials.nav')

<div class="container-fluid forum">
    <div class="row px-5">
        @include("forum.partials.forum-left")
        <section class="col-7 forum-content">
            <div class="forum-content__heading-img"></div>

            <form action="" method="POST" class="forum-content__search">
                <div action="" method="GET" class="form-search">
                    <input type="text" class="form-control form-control-lg input-search" placeholder="Computer Science...">
                    <svg class="svg-search">
                        <use xlink:href="{{asset('assets/sprite.svg#icon-search')}}"></use>
                    </svg>
                </div>
                <select name="" class="forum-content__search__search-by">
                    <option value="tags">Search by Tags</option>
                    <option value="keywords">Search by Keywords</option>
                </select>
                <select name="" class="forum-content__search__sort-by">
                    <option value="popular">Popular First</option>
                    <option value="latest">Latest First</option>
                </select>
            </form>

        </section>

        <section class="col-3 forum-right">
            dgsdlghskdl
        </section>
    </div>
</div>








{{-- @include('partials.footer') --}}

@endsection




@section('js')
<script>

</script>
<script src="{{ asset('js/forum/index.js') }}"></script>
@endsection
