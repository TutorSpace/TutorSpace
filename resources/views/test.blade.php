@extends('layouts.app')

@section('title', 'Test')

@section('body-class')
bg-white-dark-4

@if(Auth::check() && Auth::user()->is_tutor)
bg-tutor
@else
bg-student
@endif

@endsection

@section('links-in-head')


@section('content')

@include('partials.nav')



@endsection

@section('js')

<script>

    getOnboarding(1);

    function getOnboarding(num) {
        @if(Auth::user()->is_tutor)
        if(num == 7) dialog.modal('hide');
        @else
        if(num == 5) dialog.modal('hide');
        @endif

        JsLoadingOverlay.show(jsLoadingOverlayOptions);
        $.ajax({
            type: 'GET',
            url: "{{ url('/onboarding') }}" + `/${num}`,
            complete: () => {
                JsLoadingOverlay.hide();
            },
            success: (data) => {
                let dialog = bootbox.dialog({
                    message: data.view,
                    centerVertical: true,
                    closeButton: false,
                    className: 'modal-onboarding-container',
                });
                $('.btn-next').click(function() {
                    dialog.modal('hide');
                    getOnboarding(num + 1);
                })
            },
            error: (error) => {
                console.log(error);
            }
        });
    };


</script>

@endsection
