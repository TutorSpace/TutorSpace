@extends('layouts.loggedin')
@section('title', 'make tutor request')

@section('content')

<div class="container">
    <div>
        @if(!$from)
                <a class="btn btn-lg back-button" id="back-button" href="/home">
                    <svg>
                        <use xlink:href="{{asset('assets/sprite.svg#icon-chevron-small-left')}}"></use>
                    </svg>
                    Back to Home
                </a>
            @elseif($from == 'search')
                <a class="btn btn-lg back-button" id="back-button" href="/search?navInput=">
                    <svg>
                        <use xlink:href="{{asset('assets/sprite.svg#icon-chevron-small-left')}}"></use>
                    </svg>
                    Back to Search
                </a>
            @else
                <a class="btn btn-lg back-button" id="back-button" href="/{{$from}}">
                    <svg>
                        <use xlink:href="{{asset('assets/sprite.svg#icon-chevron-small-left')}}"></use>
                    </svg>
                    Back to {{ucwords($from)}}
                </a>
            @endif
    </div>

    <form action="" class="" method="POST">
        @csrf
        <h4></h4>

    </form>


</div>



@endsection

@section('js')

<script src="{{asset('js/show_tutor_request.js')}}"></script>

@endsection
