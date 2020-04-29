let receiverId;
let myId;
Date.prototype.yyyymmdd = function () {
    var mm = this.getMonth() + 1; // getMonth() is zero-based
    var dd = this.getDate();

    return [this.getFullYear(),
        (mm > 9 ? '' : '0') + mm,
        (dd > 9 ? '' : '0') + dd
    ].join('-');
};



$( document ).ready(function() {
    myId = $('#current-user-profile-photo').attr('data-user-id');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('4617c13957e71ba6c650', {
        cluster: 'us3'
    });

    var channel = pusher.subscribe('chatting-channel');
    channel.bind('new-message', function(data) {
        data = data.message;
        console.log("my id: " + myId);
        console.log("data: " + data);
        console.log("from: " + data.from);
        console.log("to: " + data.to);

        // if I am the sender
        if(myId == data.from) {
            // if I am currently in this window, push the message to the window. We don't care about it if it is not the current window
            if(receiverId && receiverId == data.to) {
                let d = new Date(data.time);
                let time = d.yyyymmdd() + " " + d.getHours() + ":" + getMinutesFormat(d);

                let msg = `<div class="message-self-container">
                    <div class="message-self">
                    ${data.msg}
                    </div>
                    <span class="time">
                    ${time}
                    </span>
                </div>`;

                $('.messages-container').append(msg);
            }
        }
        // if receiving a message
        else if(myId == data.to) {
            // if receiver is selected, push the data to the window
            if(receiverId && receiverId == data.from) {
                let d = new Date(data.time);
                let time = d.yyyymmdd() + " " + d.getHours() + ":" + getMinutesFormat(d);

                let msg = `<div class="message-other-container">
                    <div class="message-other">
                    ${data.msg}
                    </div>
                    <span class="time">
                    ${time}
                    </span>
                </div>`;

                $('.messages-container').append(msg);
                scrollToBottom();
            }
            // if not selected, update there is unread message!
            else {
                $($('.messages-table-left tr[data-user-id="' + data.from + '"] td')).addClass('unread');
            }
        }
        else {
            toastr.error("oh no!");
        }
    });




    $('.messages-table-left tr').click(function() {
        // if the user clicked on the same chatbox, dont do anything
        if(receiverId && receiverId == $(this).attr('data-user-id')) {
            return;
        }

        // if there was a chatbox, make it to normal
        if($('.messages-table-left tr[data-user-id="' + receiverId + '"]')[0]) {
            $('.messages-table-left tr[data-user-id="' + receiverId + '"]').removeClass('hover-background');
        }


        $(this).addClass('hover-background');

        receiverId = $(this).attr('data-user-id')

        showAllMsg($(this).attr('data-user-id'));
    });


    $('#form-search-message').submit(function(e) {
        e.preventDefault();
        alert("the searching message functionality is coming soon!");
    })

})


function getMinutesFormat(date) {
    if (date.getMinutes() < 10) {
        return "0" + date.getMinutes();
    }
    return date.getMinutes();
}

function sendMessage() {
    let message = $('#msg-to-send').val();

    let validMsg = message && message.trim().length !== 0 && receiverId;
        // if is valid message and have clicked on someone to send the message
    if(!validMsg) {
        alert("You must select a chatbox and input a valid message!");
        return;
    }

    // sending message here
    let datastr = "receiver_id=" + receiverId + "&message=" + message;

    $.ajax({
        type: 'post',
        url: '/messages',
        data: datastr,
        cache: false,
        success: function(data) {
            $('#msg-to-send').val('');

        },
        error: function(jqXHR, status, err) {
            alert("wrong!")
        },
        complete: function() {
            // scroll to the bottom
            scrollToBottom();
        }
    });
}

function sendMessageEnter(e) {
    if (e.keyCode == 13) {
        sendMessage();
    }
}


function declineRequest(e) {
    let requestId = $(e).attr('data-request-id');

    $.ajax({
        type:'POST',
        url: '/tutor_request_reject',
        data: {
            tutor_request_id: requestId
        },
        success: (data) => {
            toastr.success(data.successMsg);
            $('.message-alert[data-request-id="' + requestId + '"]').remove();
            $('.request-pending[data-request-id="' + requestId + '"]').remove();
        },
        error: function(error) {
            console.log(error);
            toastr.error(error);
        }
    });
}

function acceptRequest(e) {
    let requestId = $(e).attr('data-request-id');

    $.ajax({
        type:'POST',
        url: '/tutor_request_accept',
        data: {
            tutor_request_id: requestId
        },
        success: (data) => {
            if(data.errorMsg) {
                toastr.error(data.errorMsg);
            }
            else {
                toastr.success(data.successMsg);
                $('.message-alert[data-request-id="' + requestId + '"]').remove();
                $('.request-pending[data-request-id="' + requestId + '"]').remove();
            }
        },
        error: function(error) {
            console.log(error);
            toastr.error(error);
        }
    });
}



function scrollToBottom() {
    $('.messages-container').animate({
        scrollTop: $('.messages-container')[0].scrollHeight
    }, );
}

function showAllMsg(userId) {
    $.ajax({
        type: 'GET',
        url: '/detailedMessages/' + userId,
        data: "",
        cache: "false",
        success: function(data) {
            $('.m-right-container').html(data);

            // maark as read
            $('.messages-table-left tr[data-user-id="' + receiverId + '"] td').removeClass('unread');

            // scroll to the bottom
            scrollToBottom();
        },
        error: function(err) {
            console.log(err);
        }
    })
}


