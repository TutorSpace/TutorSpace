<script>
    function drawGraph() {
        let height = 350;

        if($(window).width() < 992) {
            height = 200;
        }

        scatterGraphLayout.height = height;
        gaugeGraphLayout.height = height;
        Plotly.newPlot('scatter-chart', scatterData, scatterGraphLayout, options);
        // Plotly.newPlot('gauge-chart', gaugeData, gaugeGraphLayout, options);

    }

    var postViewCntData = {
        x: [
            @foreach(App\Post::getViewCntWeek(Auth::id()) as $view)
            "{{ $view->viewed_at }}",
            @endforeach
        ],
        y: [
            @foreach(App\Post::getViewCntWeek(Auth::id()) as $view)
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
            @foreach(App\User::getViewCntWeek(Auth::id()) as $view)
            "{{ $view->viewed_at }}",
            @endforeach
        ],
        y: [
            @foreach(App\User::getViewCntWeek(Auth::id()) as $view)
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
        font: {
            size: 10,
            family: 'Arial',
        },
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

    drawGraph();
    $(window).resize(function() {
        drawGraph();
    });



    const oneStar = {{Auth::user()->getStarReviewPercentage(1)}} ;
    const twoStar = {{Auth::user()->getStarReviewPercentage(2)}};
    const threeStar = {{Auth::user()->getStarReviewPercentage(3)}};
    const fourStar = {{Auth::user()->getStarReviewPercentage(4)}};
    const fiveStar = {{Auth::user()->getStarReviewPercentage(5)}};

    var data = [oneStar,twoStar,threeStar,fourStar,fiveStar];

    if (!oneStar && !twoStar && !threeStar && !fiveStar && !fourStar){
        data = [];
    }


    var ratingChart = document.getElementById('rating-chart');
    console.log(ratingChart)
    data = {
        datasets: [{
            data: data,
            backgroundColor: [
                '#dc3545',
                '#FFBC00',
                '#dc3545',
                '#dc3545',
                '#dc3545',
            ]
        }],

        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: [
            'Five Star Ratings',
            'Four Star Ratings',
            'Three Star Ratings',
            'Two Star Ratings',
            'one Star Ratings',
        ],

    };

    const ratingChartOption = {
        position: 'right',

    }
    var ratingChart = new Chart(ratingChart, {
        type: 'doughnut',
        data: data,
        options: {
            legend: {
                position: 'right',
            },
            title: {
                display: true,
                text: 'Tutor Session Ratings (percentage)',
                // lineHeight: 0.1,
            },
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            },
            aspectRatio: 1,
            maintainAspectRatio: false
        },

    });

</script>
