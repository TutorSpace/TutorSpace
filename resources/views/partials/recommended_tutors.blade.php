@foreach (Auth::user()->getRecommendedTutors() as $user)
    @include('partials.user_card', [
        'user' => $user
    ])
@endforeach
