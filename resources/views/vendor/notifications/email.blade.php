@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Regards'),<br>
{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@if (isset($actionText))
    {{-- if this is a subscription email --}}
    @if(isset($isSubscriptionEmail) && $isSubscriptionEmail)
        @slot('subcopy')
            @lang(
                "If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
                "into your web browser: [:displayableActionUrl](:actionURL)\n\n" .
                "Dont't want to receive latest news from us? Click [here](:unsubscribeUrl) to unsubscribe from TutorSpace"
                ,[
                    'actionText' => $actionText,
                    'actionURL' => $actionUrl,
                    'displayableActionUrl' => $displayableActionUrl,
                    'unsubscribeUrl' => route('subscription.destroy', [
                        'email' => $email
                    ]),
                ]
            )
        @endslot
    @else
        @slot('subcopy')
            @lang(
                "If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
                "into your web browser: [:displayableActionUrl](:actionURL)\n\n"
                ,[
                    'actionText' => $actionText,
                    'actionURL' => $actionUrl,
                    'displayableActionUrl' => $displayableActionUrl,
                ]
            )
        @endslot
    @endif
@else
    @if(isset($isSubscriptionEmail) && $isSubscriptionEmail)
        @slot('subcopy')
            @lang(
                "Dont't want to receive latest news from us? Click [here](:unsubscribeUrl) to unsubscribe from TutorSpace"
                ,[
                    'unsubscribeUrl' => route('subscription.destroy', [
                        'email' => $email
                    ]),
                ]
            )
        @endslot
    @endif
@endif
@endcomponent
