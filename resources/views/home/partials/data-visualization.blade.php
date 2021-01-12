<script>
    function drawGraph() {
        let height = 350;

        if($(window).width() < 992) {
            height = 200;
        }

        scatterGraphLayout.height = height;
        Plotly.newPlot('scatter-chart', scatterData, scatterGraphLayout, options);
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
            family: 'Avenir, sans-serif',
            color: '#474747',
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
    scatterGraphLayout.title = {
        text: 'Post/Profile View Count Data',
        font: {
            family: 'Avenir, sans-serif',
            size: 16,
            color: '#474747'
        }
    };

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

    const oneStar = {{Auth::user()->getStarReviewCounts(1)}} ;
    const twoStar = {{Auth::user()->getStarReviewCounts(2)}};
    const threeStar = {{Auth::user()->getStarReviewCounts(3)}};
    const fourStar = {{Auth::user()->getStarReviewCounts(4)}};
    const fiveStar = {{Auth::user()->getStarReviewCounts(5)}};

    var data = [oneStar,twoStar,threeStar,fourStar,fiveStar];
    // var data = [1,2,3,4,5];
    var backgroundColor = [
<<<<<<< HEAD
                '#6749DF',
                '#8B73EB',
                '#A28FF0',
                '#BDB0F1',
                '#D9D2F4',
            ];
    var labels =  [
            'Five Star',
            'Four Star',
            'Three Star',
            'Two Star',
            'One Star',
        ]
    var legendPosition = "right";
=======
        '#dc3545',
        '#FFBC00',
        '#dc3545',
        '#dc3545',
        '#dc3545',
    ];

    var labels =  [
        'Five Star',
        'Four Star',
        'Three Star',
        'Two Star',
        'One Star',
    ];

>>>>>>> 14707cff92ae87333a26cf01dd93d496465be55c
    if (!oneStar && !twoStar && !threeStar && !fiveStar && !fourStar){
        data = [1];
        backgroundColor = ['#c2c0b8'];
        labels = ["No Available Ratings"];
        legendPosition = "bottom";
    }


    var ratingChart = document.getElementById('rating-chart');
    data = {
        datasets: [{
            data: data,
            backgroundColor: backgroundColor
        }],

        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: labels
    };

    const ratingChartOption = {
        position: 'bottom',

    }
    var ratingChart = new Chart(ratingChart, {
        type: 'doughnut',
        data: data,
        options: {
            legend: {
                position: legendPosition,
                labels: {
                    fontFamily: "Avenir, sans-serif",
                    fontSize: 10,
                    fontColor: "#474747"
                }
            },
            title: {
                display: true,
                text: 'Tutor Session Ratings',
                fontFamily: "Avenir, sans-serif",
                fontSize: 16,
                fontStyle: 200,
                fontColor:"#474747",
                lineHeight: 1.3
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
