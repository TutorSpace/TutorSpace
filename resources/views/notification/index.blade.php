@extends('layouts.app')

@section('title', 'Notifications')

@section('links-in-head')
{{-- fullcalendar --}}
<link href='https://use.fontawesome.com/releases/v5.0.6/css/all.css' rel='stylesheet'>
<script src='{{asset('fullcalendar/main.min.js')}}'></script>
@endsection

@section('body-class')
bg-white-dark-4

@if(Auth::check() && Auth::user()->is_tutor)
bg-tutor
@else
bg-student
@endif

@endsection


@section('content')

@include('partials.nav')

<div class="notification container-lg">
    <div class="row notification-container">
        <div class="notification__side-bar--left">
            @include('notification.side-bar--left')
        </div>
        <div class="notification__content" id="notification__content">
            @include('notification.content.placeholder')
        </div>
    </div>
</div>

@endsection

@section('js-2')
<script>

    $(document).on('click', '#btn-rate-tutor', function() {
        let url = $(this).attr('data-route-url');

        bootbox.dialog({
            message: `@include('session.review-session')`,
            size: 'large',
            centerVertical: true,
            buttons: {
                Cancel: {
                    label: 'Cancel',
                    className: 'btn btn-outline-primary px-4 fs-1-6',
                    callback: function(e) {}
                },
                Submit: {
                    label: 'Submit',
                    className: 'btn btn-primary px-4 fs-1-6',
                    callback: function(e) {
                        if (!$.trim($(".modal-session-report textarea").val())) {
                            // textarea is empty or contains only white-space
                            toastr.error('Please enter the details.')
                            return false;
                        }
                        JsLoadingOverlay.show(jsLoadingOverlayOptions);

                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: $('.modal-session-report').serialize(),
                            success: (data) => {
                                toastr.success(data.successMsg);
                            },
                            error: function(error) {
                                toastr.error('You can not review the same session twice!');
                                console.log(error);
                            },
                            complete: () => {
                                JsLoadingOverlay.hide();
                            }
                        });
                    }
                }
            }
        });
    });

    $(document).on("click",".msgs .msg", function () {
        let notifId = $(this).attr('data-notif-id');
        JsLoadingOverlay.show(jsLoadingOverlayOptions);
        $.ajax({
            type:'GET',
            url: '{{ url('/notifications') }}' + '/' + notifId,
            success: (data) => {
                let { view } = data;

                $('#notification__content').html(view);

                $(`.msgs .msg[data-notif-id=${notifId}]`).removeClass('unread');
            },
            error: function(error) {
                console.log(error);
                toastr.error(error);
            },
            complete: () => {
                JsLoadingOverlay.hide();
            }
        });
    });

    @if(isset($showNotif))
    $('.msgs .msg[data-notif-id={{ $showNotif }}]').click();
    @endif
</script>
@endsection
