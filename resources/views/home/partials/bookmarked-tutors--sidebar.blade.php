
@php
    $bookmarkedUsers = Auth::user()->bookmarkedUsers;
@endphp
@if ($bookmarkedUsers->count() == 0)
<div class="d-flex align-items-center justify-content-between mb-1 flex-100 no-data p-relative">
    <span class="mb-0 ws-no-wrap">Bookmarked Tutors</span>
    <span class="no-data__content">No Bookmarked Tutors</span>
</div>
@else
<div class="d-flex align-items-center justify-content-between mb-1 flex-100">
    <span class="mb-0 ws-no-wrap">Bookmarked Tutors</span>
    @if ($bookmarkedUsers->count() > 2 + 1)
    <button class="btn btn-link fs-1-2 fc-grey ws-no-wrap btn-view-all-bookmarked-users">View All</button>
    @endif
</div>

<div class="bookmarked-users">
    @foreach ($bookmarkedUsers as $key => $user)
        @include('home.partials.bookmarked-tutor', [
            'user' => $user,
            'hidden' => $key > 2
        ])
    @endforeach
</div>

@endif

