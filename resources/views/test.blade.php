<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script   src="https://code.jquery.com/jquery-3.5.1.min.js"   integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="   crossorigin="anonymous"></script>
  
</head>
<body>
  <h1> Test</h1>
  <!-- <p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
  </p> -->


 
    <div class="mb-5">
        <div class="d-flex flex-column justify-content-center align-items-center position-relative fc-grey fs-2-4 text-center" id="upload-file">
            Drop files here...
            <div class="mt-3 btn btn-primary text-center" id="upload-file-button">
                <label class="pt-1 pb-0 px-5" for="file">or click here</label>
                <input type="file" name="file" id="tutor-verification-file" />
            </div>
        </div>
    </div>







  <button id="test-btn">testing</button>
  <div>
    <input id="test-input"placeholder="enter"/>
  </div>
  <div id="content"></div>
</body>
<script>

  // delay with specified time, returns a promise
  function shortDelay(time) { 
        return new Promise(function(resolve, reject) { 
            setTimeout(resolve, time); 
        })
  } 

  // returns an ajax result with the given search query
  function ajaxRequest(query){
      return $.ajax({
      url:"{{ route('test.action') }}",
      method:'GET',
      data:{query:query},
      dataType:'json'})
      .done(function(data){
        return data;
      })  
  }

  // used for avoiding unnecessary ajax calls
  var num = 0;

  // key down triggers ajax for auto complete
  $("#test-input").keydown(function(){
    // used for avoid redundant ajax
    num += 1;
    var curNum = num;
    // get the query
    const query = event.target.value;
    // only do the following when user inputs something
    if (query.length >= 1){
      // delay
      shortDelay(50).then(()=>{
      if (num === curNum){
        ajaxRequest(query).then((data)=>{
          // clear content and add auto complete options
          $("#content").empty();
          $.each(data,function(index,value){
              $("#content").append('<div>"'+value.course+'"<div>');
          });
        })
        num = 0;
      }    
    })
    }else{
      $("#content").empty();
    } 
  }


  );


  $("#test-btn").click(function(){
    var file = $("#tutor-verification-file")[0].files[0];
    if (file){ // not empty
      uploadFile(file);
    }else{ // display error message
      
    }


    // email().then(data=>{
    //   alert(data);
    // })
  });
  function email(){
      alert("ajax")
      return $.ajax({

      url:"{{ route('abc') }}",
      method:'GET',
      data:{query:"query"},
      dataType:'json'})
      .done(function(data){
        return data;
      })  
      alert("ajax")
  }

  function uploadFile(file){
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

  $("#tutor-verification-file").change(function () {
    var fileInput = $(this)[0];
    var file = fileInput.files[0];
    var formData = new FormData();
    formData.append('tutor-verification', file);

    // $.ajax({
    //   type: 'POST',
    //   url: $('#profile-pic-form').attr('action'),
    //   data: formData,
    //   contentType: false,
    //   processData: false,
    //   success: function success(data) {
    //     toastr.success('Successfully uploaded the image!');
    //     $('#profile-image').attr('src', storageUrl + data.imgUrl);
    //     console.log(storageUrl + data.imgUrl);
    //     $('.nav-right__profile-img').attr('src', storageUrl + data.imgUrl);
    //   },
    //   error: function error(_error) {
    //     toastr.error('Something went wrong. Please try again.');
    //     console.log(_error);
    //   }
    // });
}); 
  // Enable pusher logging - don't include this in production
  // Pusher.logToConsole = true;

  // var pusher = new Pusher('d8a4fc3115898457a40f', {
  //     cluster: 'us3',
  //     authEndpoint: '/broadcasting/auth',
  //     encrypted: true,
  //     auth: {
  //         headers: {
  //             'X-CSRF-Token': "{{ csrf_token() }}"
  //         }
  //     }
  // });

  // var channel = pusher.subscribe('private-message.1-2');
  // channel.bind('NewMessage', function(data) {
  //     alert(JSON.stringify(data));
  // });
</script>
