$("#start-timer").click(() => {
    // dont define starTiming anywhere outside or using let/var, because we want to create a global variable
    startTiming = setInterval(setTime, 1000);
});


$("#clear-timer").click(() => {
    clearInterval(startTiming);
    secondLabel.innerHTML = "00";
    minuteLabel.innerHTML = "00";
    hourLabel.innerHTML = "00";
    totalSeconds = 0;
});

$("#stop-timer").click(() => {
    clearInterval(startTiming);
});



let secondLabel = $('#second')[0];
let minuteLabel = $('#minute')[0];
let hourLabel = $('#hour')[0];

let totalSeconds = 0;

function setTime() {
    ++totalSeconds;
    let minuteCnt = parseInt(totalSeconds / 60);
    let hourCnt = parseInt(minuteCnt / 60);
    secondLabel.innerHTML = pad(totalSeconds % 60);
    minuteLabel.innerHTML = pad(minuteCnt % 60);
    hourLabel.innerHTML = pad(hourCnt);
}

function pad(val) {
    var valString = val + "";
    if (valString.length < 2) {
        return "0" + valString;
    } else {
        return valString;
    }
}


if($('.notes-for-student')[0]) {
    $('#btn-reset').click(function() {
        $('.notes-for-student > textarea').val('');
    });
    $('#btn-share-notes').click(function() {
        alert('The sharing notes and ending session functionality is coming soon!');
    });
}
