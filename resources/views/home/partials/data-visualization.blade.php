<script>
    function drawGraph() {
        let height = 350;

        if($(window).width() < 992) {
            height = 200;
        }

        scatterGraphLayout.height = height;
        gaugeGraphLayout.height = height;
        Plotly.newPlot('scatter-chart', scatterData, scatterGraphLayout, options);
        Plotly.newPlot('gauge-chart', gaugeData, gaugeGraphLayout, options);
    }

    var postViewCntData = {
        x: [
            @foreach(App\Post::getViewCntWeek(1) as $view)
            "{{ $view->viewed_at }}",
            @endforeach
        ],
        y: [
            @foreach(App\Post::getViewCntWeek(1) as $view)
            "{{ $view->view_count }}",
            @endforeach
        ],
        type: 'scatter',
        mode: 'lines+markers',
        name:'Post View Count',
        hovertemplate: '%{y}<extra></extra>',
    };

    var profileViewCntData = {
        x: [
            @foreach(App\User::getViewCntWeek(1) as $view)
            "{{ $view->viewed_at }}",
            @endforeach
        ],
        y: [
            @foreach(App\User::getViewCntWeek(1) as $view)
            "{{ $view->view_count }}",
            @endforeach
        ],
        type: 'scatter',
        mode: 'lines+markers',
        name:'Profile View Count',
        hovertemplate: '%{y}<extra></extra>',
    };

    var scatterData = [postViewCntData, profileViewCntData];

    var layout = {
        showlegend: true,
        font: {size: 10},
        legend: {
            xanchor: 'right',
        },
        margin: {
            l: 30,
            r: 25,
            b: 35,
            t: 50,
            pad: 0
        },
        yaxis: {fixedrange: true},
        xaxis : {fixedrange: true},
        plot_bgcolor: "#F9F9F9",
        paper_bgcolor:"#F9F9F9",
    };

    // create a deep copy of layout
    var scatterGraphLayout = Object.assign({}, layout);
    scatterGraphLayout.title = 'Post/Profile View Count Data';

    var options = {
            scrollZoom: true,
            displaylogo: false,
            displayModeBar: false,
            responsive: true,
        };

    // for the gauge chart
    var gaugeData = [{
        domain: { row: 1, column: 1 },
        value: {{ Auth::user()->getFiveStarReviewPercentage() }},
        type: "indicator",
        mode: "gauge+number+delta",
        number: {
            suffix: "%"
        },
        delta: {
            // todo: modify the reference
            reference: 70,
            increasing: {
                // color: ""
            }
        },
        gauge: {
            axis: { range: [0, 100] },
            // bgcolor: "white",
            color: "red",
            bar: {
                color: "#FFBC00"
            }
        }
    }];

    var gaugeGraphLayout = Object.assign({}, layout);
    gaugeGraphLayout.title = '5-Star Rating';
    gaugeGraphLayout.margin = {
        l: 30,
        r: 30,
        b: 35,
        t: 50,
        pad: 0
    };

    drawGraph();
    $(window).resize(function() {
        drawGraph();
    });
</script>
