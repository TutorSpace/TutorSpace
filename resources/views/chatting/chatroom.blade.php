@extends('layouts.loggedin')
@section('title', 'chatting room')

@section('links-in-head')
<script src="https://js.pusher.com/6.0/pusher.min.js"></script>
@endsection

@section('content')
<div class="container">
    <div class="m-header-container">
        <h2>Messages <span>(10)</span></h2>
    </div>

    <div class="row">
        <div class="col-3 m-left-container">
            <div class="search-messages-container">
                <svg>
                    <use xlink:href="assets/sprite.svg#icon-magnifying-glass"></use>
                </svg>
                <input type="text" class="search-messages" placeholder="Search Messages">
            </div>

            <table class="table table-hover messages-table-left">
                <tbody>
                    <tr>
                        <td class="first-td">
                            <div class="messages-table-left-top">
                                <span class="name">Jamie C.</span>
                                <span class="request-pending">Request Pending</span>
                            </div>
                            {{-- <span class="time">3:27pm</span> --}}
                        </td>
                    </tr>
                    <tr>
                        <td class="unread">
                            <div class="messages-table-left-top">
                                <span class="name">Jamie C.</span>

                            </div>
                            {{-- <span class="time">3:27pm</span> --}}
                        </td>
                    </tr>
                    <tr>
                        <td class="unread">
                            <div class="messages-table-left-top">
                                <span class="name">Jamie C.</span>
                                <span class="request-pending">Request Pending</span>
                            </div>
                            {{-- <span class="time">3:27pm</span> --}}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-9 m-right-container">
            <div class="header">
                <img src="assets/mj.jpg" alt="user photo">
                <h3>Jamie</h3>
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

            {{-- <div class="message-alert message-alert--request">
                <div>
                    <span>Date</span>
                    <span>Wednesday, March 15, 2020</span>
                </div>
                <div>
                    <span>Subject / Course</span>
                    <span>ITP 104</span>
                </div>
                <div>
                    <span>Start Time</span>
                    <span>4:30pm</span>
                </div>
                <div>
                    <span>End Time</span>
                    <span>6:30pm</span>
                </div>
                <div class="btn-container">
                    <button class="btn btn-outline-primary mr-3" id="btn-decline-request">Decline</button>
                    <button class="btn btn-primary" id="btn-accept-request">Accept</button>
                </div>
            </div> --}}

            <div class="messages-container">
                <div class="message-other-container">
                    <div class="message-other">
                        Thank you for reaching out! I would
                        love to tutor you in ARCH 110
                    </div>
                    <span class="time">time</span>
                </div>


                <div class="message-self-container">
                    <p class="message-self"> That sounds great! I’ll check your
                        calendar and see when we can
                        meet up!</p>

                </div>
                <div class="message-other">
                    Sounds good! Let me know if you
                    have any questions in the meantime
                </div>
                <div class="message-other">
                    Thank you for reaching out! I would
                    love to tutor you in ARCH 110
                </div>
                <div class="message-self-container">
                    <p class="message-self"> That sounds great! I’ll check your
                        calendar and see when we can
                        meet up!</p>

                </div>
                <div class="message-other">
                    Sounds good! Let me know if you
                    have any questions in the meantime
                </div>
                <div class="message-other">
                    Thank you for reaching out! I would
                    love to tutor you in ARCH 110
                </div>
                <div class="message-self-container">
                    <p class="message-self"> That sounds great! I’ll check your
                        calendar and see when we can
                        meet up!</p>

                </div>
                <div class="message-other">
                    Sounds good! Let me know if you
                    have any questions in the meantime
                </div>
                <div class="message-other">
                    Thank you for reaching out! I would
                    love to tutor you in ARCH 110
                </div>
                <div class="message-self-container">
                    <p class="message-self"> That sounds great! I’ll check your
                        calendar and see when we can
                        meet up!</p>

                </div>
                <div class="message-other">
                    Sounds good! Let me know if you
                    have any questions in the meantime
                </div>
            </div>

            <div class="message-input-container">
                <input type="text" class="message-input" placeholder="Type a message...">
                <button>Send</button>
            </div>

        </div>
    </div>

</div>


<!-- defined javascript -->
<script src="{{asset("js/messages.js")}}"></script>

@endsection




