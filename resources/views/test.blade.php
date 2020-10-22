{{-- @extends('layouts.app')

@section('links-in-head')
<script src="https://www.gstatic.com/charts/loader.js"></script>
@endsection

@section('content')
<div id="pie-chart"/>
@endsection

@section('js')
<script>

      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Rating', 'Rating Scroe'],
          ['5.0',     11],
          ['4.5',      2],
          ['4',  2],
          ['3.5', 2],
          ['3',    7]
        ]);

        var options = {
          title: 'My Daily Activities'
        };

        var chart = new google.visualization.PieChart(document.getElementById('pie-chart'));

        chart.draw(data, options);
      }
</script>
@endsection --}}



@extends('layouts.app')

@section('links-in-head')

@endsection

@section('content')

<div id="post-chart"/>

<div id="profile-chart"></div>
@endsection

@section('js')
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
    width: 600,
    height: 250,
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
    width: 600,
    height: 250,
    target: '#profile-chart',
    x_accessor: 'date',
    y_accessor: 'value',
    linked: true,
    top: 50
})
</script>
@endsection
