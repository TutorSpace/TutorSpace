@extends('layouts.app')

@section('title', 'Dashboard - Forum Activities')

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

<div class="container-fluid home p-relative">
    @include('home.partials.menu_bar')
    <main class="home__content">
        <div class="container home__header-container">
            <div class="heading-container">
                <p class="heading">Forum Activities</p>
                <span>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed enim blanditiis ipsam nesciunt quia culpa eaque eligendi
                </span>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <h5 class="mb-2 w-100">Data Visualization</h5>
                <div class="home__data-visualizations">
                    <div id="post-chart"></div>
                    <div id="profile-chart"></div>
                </div>
            </div>
        </div>

    </main>

</div>


@endsection

@section('js')

<script>
let storageUrl = "{{ Storage::url('') }}";
</script>


{{-- for graphics --}}
<script>
    MG.data_graphic({
        title: "Post View Count",
        description: "This graphic shows a time-series of post view counts.",
        data: [
            @foreach(App\Post::getViewCntWeek(1) as $view)
            {
                'date':new Date('{{ $view->viewed_at }}'),
                'value': {{ $view->view_count }}
            },
            @endforeach
        ],
        width: 300,
        // height: 250,
        target: '#post-chart',
        x_accessor: 'date',
        y_accessor: 'value',
        linked: true,
        top: 50
    })

    MG.data_graphic({
        title: "Profile View Count",
        description: "This graphic shows a time-series of profile view counts.",
        data: [
            @foreach(App\User::getViewCntWeek(1) as $view)
            {
                'date':new Date('{{ $view->viewed_at }}'),
                'value': {{ $view->view_count }}
            },
            @endforeach
        ],
        width: 300,
        // height: 250,
        target: '#profile-chart',
        x_accessor: 'date',
        y_accessor: 'value',
        linked: true,
        top: 50
    })
</script>

<script src="{{ asset('js/home/index.js') }}"></script>
@endsection
