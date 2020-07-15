@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 86.23 77.04"><defs><style>.cls-1{fill:#F8F8F8;}.cls-2{fill:none;stroke:#F8F8F8;stroke-miterlimit:10;stroke-width:5px;}</style></defs><g id="图层_2" data-name="图层 2"><g id="图层_1-2" data-name="图层 1"><circle class="cls-1" cx="6.42" cy="39.1" r="6.42"/><path class="cls-2" d="M83.18,13.75,55.54,36.58a5.8,5.8,0,0,1-5.66,1L16.15,25.42a1.52,1.52,0,0,1-.35-2.68L42.21,4.51a11.39,11.39,0,0,1,9.38-1.63l31,8.23A1.52,1.52,0,0,1,83.18,13.75Z"/><path class="cls-2" d="M28.12,30.57a29.18,29.18,0,0,0,5.41,36.26.17.17,0,0,1,0,.19l-4.22,7.29a.16.16,0,0,0,.14.23H52.63c16.23,0,29.85-13,29.85-29.19a29.15,29.15,0,0,0-9.35-21.42"/></g></g></svg>

{{ config('app.name') }}
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
