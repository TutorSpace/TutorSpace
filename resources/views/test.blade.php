@extends('layouts.app')

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
@endsection

