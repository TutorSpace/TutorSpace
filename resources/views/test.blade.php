@extends('layouts.app')

@section('title', 'Dashboard')

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
        JsLoadingOverlay.show(jsLoadingOverlayOptions);
        $.ajax({
            type: 'GET',
            url: "{{ route('onboarding') }}",
            complete: () => {
                JsLoadingOverlay.hide();
            },
            success: (data) => {
                bootbox.dialog({
                    message: data.view,
                    centerVertical: true,
                    closeButton: false,
                    className: 'modal-onboarding-container',
                });
                $('.modal-content').addClass('bg-white-dark-5');
            },
            error: (error) => {
                console.log(error);
            }
        });
</script>

@endsection
