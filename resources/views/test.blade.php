<!DOCTYPE html>

<head>
    <title>Pusher Test</title>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

</head>

<body>
    <h1> Test</h1>
    <!-- <p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
  </p> -->
    <form action="{{ route('test.action') }}" method="GET">
        <input type="file" name="file">
        <button type="submit">submit</button>
    </form>
</body>
<script>
    // delay with specified time, returns a promise
    function shortDelay(time) {
        return new Promise(function (resolve, reject) {
            setTimeout(resolve, time);
        })
    }

    // returns an ajax result with the given search query
    function ajaxRequest(query) {
        return $.ajax({
                url: "{{ route('test.action') }}",
                method: 'GET',
                data: {
                    query: query
                },
                dataType: 'json'
            })
            .done(function (data) {
                return data;
            })
    }

    // used for avoiding unnecessary ajax calls
    var num = 0;

    // key down triggers ajax for auto complete
    $("#test-input").keyup(function () {
        // used for avoid redundant ajax
        num += 1;
        var curNum = num;
        // get the query
        const query = event.target.value;
        // only do the following when user inputs something
        if (query.length >= 1) {
            // delay
            shortDelay(50).then(() => {
                if (num === curNum) {
                    ajaxRequest(query).then((data) => {
                        // clear content and add auto complete options
                        $("#content").empty();
                        $.each(data, function (index, value) {
                            $("#content").append('<div>"' + value.course + '"<div>');
                        });
                    })
                    num = 0;
                }
            })
        } else {
            $("#content").empty();
        }
    });


    $("#test-btn").click(function () {
        // var file = $("#tutor-verification-file")[0].files[0];
        // if (file){ // not empty
        //   uploadFile(file);
        // }else{ // display error message

        // }
        return $.ajax({
                url: "{{ route('abc') }}",
                method: 'GET',
                data: {
                    query: "query"
                },
                dataType: 'json'
            })
            .done(function (data) {
                console.log(data);
            })


        // email().then(data=>{
        //   alert(data);
        // })
    });

    function email() {
        alert("ajax")
        return $.ajax({
                url: "{{ route('abc') }}",
                method: 'GET',
                data: {
                    query: "query"
                },
                dataType: 'json'
            })
            .done(function (data) {
                return data;
            })
        alert("ajax")
    }

    function uploadFile(file) {
        var formData = new FormData();
        formData.append('tutor-verification-file', file);
        return $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: "{{ route('tutor-profile-verification') }}",
            data: formData,
            contentType: false,
            processData: false,

            success: function success(data) {
                // toastr.success('Successfully uploaded the image!');
                alert("sent")
                // $('#profile-image').attr('src', storageUrl + data.imgUrl);
                // console.log(storageUrl + data.imgUrl);
                // $('.nav-right__profile-img').attr('src', storageUrl + data.imgUrl);
                return data;
            },
            error: function error(_error) {
                // toastr.error('Something went wrong. Please try again.');
                // console.log(_error);
                return false;
            }
        });
    }



</script>
