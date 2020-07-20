{{-- @if ($paginator->hasPages())
    @if ($paginator->hasMorePages())
        <div class="text-center mt-5rem">
            <button class="btn btn-view-more" data-next-page-url="{{ $paginator->nextPageUrl() }}">View More</button>
        </div>
    @endif
@endif --}}


@if ($paginator->hasPages())
    <nav class="mt-5rem fs-1-6">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">@lang('pagination.previous')</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link fc-current" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link fc-current" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">@lang('pagination.next')</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
