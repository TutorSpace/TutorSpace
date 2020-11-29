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
    if (query.length >= 2){
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
