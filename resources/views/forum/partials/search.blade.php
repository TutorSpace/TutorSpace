<form action="{{ route('posts.search') }}" method="POST" class="forum-content__search">
    @csrf
    @if (!in_array(Route::current()->getName(), [
        'posts.index',
        'posts.my-follows',
        'posts.my-posts',
        'posts.popular',
        'posts.latest',
    ]))
    <a class="btn btn-lg btn-back" href="{{ App\CustomClass\URLManager::getBackURL(route('posts.index')) }}">
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
        </svg>
        Back
    </a>
    @endif

    <div class="input-content p-relative tags-container">
        <div class="input-group select-container p-relative select-container-icon">
            {{-- <svg class="select-container__icon">
                <use xlink:href="{{asset('assets/sprite.svg#icon-search')}}"></use>
            </svg> --}}
            <select class="custom-select hidden" name="tags[]" multiple="multiple" id="tags" required>
                @foreach (App\Tag::all() as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->tag }}</option>
                @endforeach
            </select>
            <div class="input-group-prepend">
                {{-- <svg>
                    <use xlink:href="{{asset('assets/sprite.svg#icon-keyboard_arrow_down')}}"></use>
                </svg> --}}
                <svg class="select-container__icon">
                    <use xlink:href="{{asset('assets/sprite.svg#icon-search')}}"></use>
                </svg>
            </div>
        </div>
    </div>
    <div class="form-search keyword-search hidden">
        <input type="text" class="form-control form-control-lg input-search" placeholder="Computer Science...">
        <svg class="svg-search">
            <use xlink:href="{{asset('assets/sprite.svg#icon-search')}}"></use>
        </svg>
    </div>

    <select name="search-by" class="forum-content__search__search-by mr-auto">
        <option value="tags">Search by Tags</option>
        <option value="keywords">Search by Keywords</option>
    </select>
</form>
