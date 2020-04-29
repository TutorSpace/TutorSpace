<div class="header">
    <img src="{{asset("user_photos/{$otherUser->profile_pic_url}")}}" alt="the other user's photo" onclick="viewUserProfile({{$otherUser->id}})">
    <h4>{{$otherUser->full_name}}</h4>
</div>

{{-- the following is for post alert! --}}
{{-- <div class="message-alert message-alert--post">
    <div>
        <p>Replying to @shopiap</p>
        <p>2/29/2020</p>
    </div>
    <span class="message-alert--post-content">I have an upcoming midterm for ITP 104 next Tuesday. Can I please get some help with </span>
    <button class="btn btn-outline-primary btn-lg">Clear</button>
    <button class="btn btn-primary btn-lg" id="go-to-post">Go to Post</button>
</div> --}}

@php
// only for tutor
$tutorRequest = App\Tutor_request::where('tutor_id', '=', $user->id)
                                    ->where('student_id', '=', $otherUser->id)->first();

@endphp
@if($tutorRequest)
{{-- the following is for tutor request alert and is only for tutor --}}
<div class="message-alert message-alert--request" data-request-id="{{$tutorRequest->id}}">
    <div>
        <span>Date</span>
        <span>{{date('l, F d, Y', strtotime($tutorRequest->tutor_session_date))}}</span>
    </div>
    <div>
        <span>Subject / Course</span>
        <span>{{$tutorRequest->is_course_request ? App\Course::find($tutorRequest->course_id)->course : App\Subject::find($tutorRequest->subject_id)->subject}}</span>
    </div>
    <div>
        <span>Start Time</span>
        <span>{{$tutorRequest->start_time}}</span>
    </div>
    <div>
        <span>End Time</span>
        <span>{{$tutorRequest->end_time}}</span>
    </div>
    <div class="btn-container">
        <button class="btn btn-outline-primary mr-3" id="btn-decline-request" data-request-id="{{$tutorRequest->id}}" onclick="declineRequest(this)">Decline</button>
        <button class="btn btn-primary" id="btn-accept-request" data-request-id="{{$tutorRequest->id}}" onclick="acceptRequest(this)">Accept</button>
    </div>
</div>
@endif

<div class="messages-container">
    @foreach ($messages as $message)
        @if($message->from == $user->id)
        <div class="message-self-container">
            <div class="message-self">
                {{$message->message}}
            </div>
            <span class="time">
                {{date('Y-m-d h:i', strtotime($message->created_at))}}
            </span>
        </div>

        @else
        <div class="message-other-container">
            <div class="message-other">
                {{$message->message}}
            </div>
            <span class="time">
                {{date('Y-m-d h:i', strtotime($message->created_at))}}
            </span>
        </div>
        @endif

    @endforeach

    {{-- <div class="message-other-container">
        <div class="message-other">
            Thank you for reaching out! I would
            love to tutor you in ARCH 110
        </div>
        <span class="time">time</span>
    </div>
    <div class="message-self-container">
        <div class="message-self"> That sounds great! I’ll check your
            calendar and see when we can
            meet up!
        </div>
        <span class="time">time</span>
    </div> --}}


</div>


<div class="message-input-container">
    <input type="text" class="message-input" id="msg-to-send" placeholder="Type a message..." onkeydown="sendMessageEnter(event)">
    <button id="btn-send-msg" onclick="sendMessage()" >Send</button>
</div>

