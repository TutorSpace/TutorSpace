{{-- Google Chart --}}
{{-- @extends('layouts.app')

@section('links-in-head')
<script src="https://www.gstatic.com/charts/loader.js"></script>
@endsection

@section('content')
<h1>test</h1>
<div id="chart"/>
@endsection

@section('js')
<script>
    google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            @foreach()
            ['Day', 'ViewCount'],
            ['08/10',  0],
            ['08/11',  3],
            ['08/12',  5]
            @endforeach
        ]);

        var options = {
          title: 'Company Performance',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart'));

        chart.draw(data, options);
      }
</script>
@endsection --}}


{{-- MetricGraphics --}}
@extends('layouts.app')

@section('links-in-head')

@endsection

@section('content')
{{-- Metric Grphics --}}
<div id="chart"/>
@endsection

@section('js')
<script>

MG.data_graphic({
    title: "Post View Count",
    description: "This graphic shows a time-series of post view counts.",
    data: [
        @foreach($views as $view)
        {
            'date':new Date('{{ $view->viewed_at }}'),
            'value': {{ $view->view_count }}
        },
        @endforeach
    ],
    width: 600,
    height: 250,
    target: '#chart',
    x_accessor: 'date',
    y_accessor: 'value',
    top: 50
})
</script>
@endsection
