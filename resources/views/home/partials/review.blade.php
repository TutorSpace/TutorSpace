<div class="@if(isset($hidden) && $hidden) hidden-2 @endif">
    <div class="info-box">
        <div class="review">
            "{{ $content }}"
        </div>

        <div class="rating">
            @php
                $starRating = Auth::user()->getAvgRating();
            @endphp
            @for ($i = 0; $i < 5; $i++)
                @if ($i < $starRating)
                <svg class="full" version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                    <title>star-full</title>
                    <path d="M32 12.408l-11.056-1.607-4.944-10.018-4.944 10.018-11.056 1.607 8 7.798-1.889 11.011 9.889-5.199 9.889 5.199-1.889-11.011 8-7.798z"></path>
                </svg>
                @else
                <svg class="empty" version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                    <title>star-empty</title>
                    <path d="M32 12.408l-11.056-1.607-4.944-10.018-4.944 10.018-11.056 1.607 8 7.798-1.889 11.011 9.889-5.199 9.889 5.199-1.889-11.011 8-7.798zM16 23.547l-6.983 3.671 1.334-7.776-5.65-5.507 7.808-1.134 3.492-7.075 3.492 7.075 7.807 1.134-5.65 5.507 1.334 7.776-6.983-3.671z"></path>
                </svg>
                @endif
            @endfor
        </div>

        <div class="time-ago">
            6 days ago
        </div>
    </div>
</div>
