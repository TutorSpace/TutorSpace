Date.prototype.yyyymmdd = function () {
    var mm = this.getMonth() + 1; // getMonth() is zero-based
    var dd = this.getDate();

    return [this.getFullYear(),
        (mm > 9 ? '' : '0') + mm,
        (dd > 9 ? '' : '0') + dd
    ].join('-');
};

let calendar;
let startTime;
let endTime;
let date;
let calendarShown = false;

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: ['timeGrid', 'interaction', 'bootstrap'],

        // default time should be los angeles' time
        timeZone: 'PDT',
        defaultView: 'timeGridWeek',
        customButtons: {
            cancelButton: {
                text: 'hide',
                click: function() {
                    $('#background-cover-3').hide();
                }
            }
        },
        header: {
            left: 'prev, next today',
            center: 'title',
            right: 'timeGridDay, timeGridWeek  cancelButton'
        },
        contentHeight: 600,
        eventColor: '#97D2FB',
        eventRender: function (info) {

        },
        eventPositioned: function (info) {

        },
        eventClick: function (eventClickInfo) {
            eventClickInfo.jsEvent.preventDefault(); // don't let the browser navigate
            if (eventClickInfo.event.url) {
                window.open(eventClickInfo.event.url);
            }
        },
        eventMouseEnter: function (mouseEnterInfo) {

        },
        eventMouseLeave: function (mouseLeaveInfo) {

        },


        allDaySlot: false,
        minTime: "06:00:00",

        // called each time a day is rendered! (including week(7 days) and month!)
        dayRender: function (dayInfo) {

        },
        validRange: function (nowDate) {
            return {
                start: nowDate
            };
        },
        navLinks: true,
        selectable: true,
        select: function (selectionInfo) {
            selectionInfo.jsEvent.stopPropagation();

            startTime = selectionInfo.start;
            endTime = selectionInfo.end;


            startTime.setHours(startTime.getHours() + 7);
            endTime.setHours(endTime.getHours() + 7);

            $('#startTime').val(startTime.toISOString());
            $('#endTime').val(endTime.toISOString());

            $('#background-cover-3').hide();

        },
        unselect: function (jsEvent, view) {

        },
        // only for the searching page
        unselectAuto: false,
        selectMirror: true,
        selectOverlap: false,
        dateClick: function (info) {
            // alert('Clicked on: ' + info.dateStr);
            // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
            // alert('Current view: ' + info.view.type);
            // // change the day's background color just for fun
            // info.dayEl.style.backgroundColor = 'red';
        },
        nowIndicator: true,
        now: function () {
            // get the pdt time
            var date = new Date();
            var utcDate = new Date(date.toUTCString());

            // i have to change to -8 when it is winter time
            utcDate.setHours(utcDate.getHours() - 7);
            var usDate = new Date(utcDate);
            return usDate;
        },

        allDayDefault: false,
    });


});









// show/hide filter
$('.filter-box > button:first-child').click(function() {
    $('.filter-box > button:first-child').each((idx, e) => {
        if($(this)[0] !== e) {
            $(e).next().hide();
        }
    })
    $(this).next().toggle();
});

// save button
$('.filter-box .button-container > button:last-child').click(function() {
    $(this).parent().parent().hide();
});


// change value of range inputs on change
$('#price-range-low').on('change', function() {
    $('#price-range-low-value').html($(this).val());
});
$('#price-range-high').on('change', function() {
    $('#price-range-high-value').html($(this).val());
});
$('#rating-range-low').on('change', function() {
    $('#rating-range-low-value').html($(this).val());
});
$('#rating-range-high').on('change', function() {
    $('#rating-range-high-value').html($(this).val());
});



// clear inputs
$('#clear-year').click(function() {
    $('.filter-year input').each(function() {
        console.log($(this).prop('checked', false));
    });
});

$('#clear-price').click(function() {
    $('#price-range-low-value').html('10');
    $('#price-range-high-value').html('25');
    $('#price-range-low').val(10);
    $('#price-range-high').val(25);
});

$('#clear-rating').click(function() {
    $('#rating-range-low-value').html('2');
    $('#rating-range-high-value').html('4');
    $('#rating-range-low').val(2);
    $('#rating-range-high').val(4);
});



$('.search-card-flex-container img').click(function() {
    window.location.href = '/view_profile/' + $(this).attr('data-user-id') + '?from=search';
})



$('#btn-show-calendar').click(function() {
    $('#background-cover-3').height(document.documentElement.scrollHeight);
    $('#background-cover-3').width(document.documentElement.scrollWidth);
    $('#background-cover-3').show();

    if(!calendarShown) {
        calendar.render();
        calendarShown = true;
    }


    let centerOffset = (document.documentElement.scrollHeight - $(window).height()) / 2;
    $('html,body').animate({
            scrollTop: centerOffset
        },
        'slow'
    );
})


$('.search__box input').on("keyup", function(e) {
    if (e.keyCode == 13) {
        $('form').submit();
    }
});



