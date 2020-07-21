<form action="{{ route('posts.search') }}" method="GET" class="forum-content__search">
    <div class="forum-content__search--normal">
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

        <div class="input-content p-relative tags-container @if(!old('search-by') || old('search-by') == 'keywords') hidden @endif">
            <div class="input-group select-container p-relative select-container-icon">
                <select class="custom-select hidden" name="tags[]" multiple="multiple" id="tags" required>
                    @foreach (App\Tag::all() as $tag)
                        <option value="{{ $tag->id }}"
                            @if (old('search-by') == 'tags')
                                @if (in_array($tag->id, old('tags') ?? []))
                                    selected
                                @endif
                            @endif
                            >
                            {{ $tag->tag }}
                        </option>
                    @endforeach
                </select>
                <div class="input-group-prepend forum-search-component">
                    <svg class="select-container__icon" id="svg-tags">
                        <use xlink:href="{{asset('assets/sprite.svg#icon-search')}}"></use>
                    </svg>
                </div>
            </div>
        </div>
        <div class="form-search keyword-search @if(old('search-by') == 'tags') hidden @endif">
            <input type="text" class="form-control form-control-lg input-search" placeholder="How is CSCI 104..." id="forum__input-search-keyword" name="keyword" @if(old('search-by') == 'keywords') value="{{ old("keyword") }}" @endif>
            <svg class="svg-search" id="svg-keyword">
                <use xlink:href="{{asset('assets/sprite.svg#icon-search')}}"></use>
            </svg>
        </div>

        <select name="search-by" class="forum-content__search__search-by mr-auto">
            <option value="keywords"
                @if(old('search-by') == 'keywords') selected
                @endif
            >
                Search by Keywords
            </option>
            <option value="tags"
                @if(old('search-by') == 'tags') selected
                @endif
            >
                Search by Tags
            </option>
        </select>
    </div>


    @if (isset($hasFilter) && $hasFilter)
    <div class="filter-container mt-3">
        <button class="btn btn-filter" type="button">
            @if(Auth::check() && Auth::user()->is_tutor)
            <svg class="mr-2" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <rect width="16" height="16" fill="url(#pattern15)"/>
                <defs>
                <pattern id="pattern15" patternContentUnits="objectBoundingBox" width="1" height="1">
                <use xlink:href="#image15" transform="scale(0.00195312)"/>
                </pattern>
                <image id="image15" width="512" height="512" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAAAAIACAMAAADDpiTIAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAABqlBMVEUAAAAjgP8fe/8eev8fev8fev8fev8fev8fev8fef8eef8kef8de/8fev8fev8fev8gef8fef8eeP8ndv8fe/8fev8fef8gev8VgP8eeP8gev8fev8fev8ggP8AAP8eev8fef8eev8AgP8dfP8fev8gev8ffP8gef8fev8eev8fef8gev8AgP8fev8fev8zZv8gev8gev8eev8fef8eef8fe/8fev8fev8fef8fev8eev8fev8fev8id/8fev8XdP8fev8ge/8gev8fev8fev8agP8fef8fe/8gev8fev8fev8fev8kgP8fev8fev8fe/8ge/8hfP8fe/8fev8fev8fe/8cfP8agP8fev8ggP8ief8fev8fev8feP8fev8hev8fe/8ccf8fev8fev8fev8eev8fev8ge/8gev8fev8fev8eev8eeP8ee/8fev8kbf8gdf8eev8fev8ce/8hd/8cff8fe/8ge/8fef8fev8gef8eev8fev8id/8ee/8fev8eev8AVf8gev8def8geP8fev8he/8fe/8fev8fev8fev8bef8fev8AAABDbjZCAAAAjHRSTlMAFlN/p83e7vqmfhU0jtP+0o0zDXLV1HEMEYDt7BABXulvAiPDwiFQ8VaLiASdowWysZ+kVFHw779iXOroD3sL63Awis8UfMzK4Pn4Dlqbmlknnvb1nCUK+wgmxxkx4y7QCf2C9Jf8V5nLyJgih8YHGOLlGy8tzol65l/Bvh5NhLADoU4gwB/n0aXdEyRlNkUAAAABYktHRACIBR1IAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAB3RJTUUH5AcOBSsEZCijjAAADQZJREFUeNrt3YtbVFUXx/ERE9DUETFS0XHI0gxfyBS7kHkBkSYQNbpwiQohA9OsLK1M7V62/+hX357XJ7Pc+8zZa62zOd/PP8D5sX7PnJkzZ9apVAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQDJWtax+bE1rW7vzaG9rXbN2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"/>
                </defs>
            </svg>
            @else
            <svg class="mr-2" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <rect width="16" height="16" fill="url(#pattern15)"/>
                <defs>
                <pattern id="pattern15" patternContentUnits="objectBoundingBox" width="1" height="1">
                <use xlink:href="#image15" transform="scale(0.00195312)"/>
                </pattern>
                <image id="image15" width="512" height="512" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAAAAIACAMAAADDpiTIAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAABqlBMVEUAAAAjgP8fe/8eev8fev8fev8fev8fev8fev8fef8eef8kef8de/8fev8fev8fev8gef8fef8eeP8ndv8fe/8fev8fef8gev8VgP8eeP8gev8fev8fev8ggP8AAP8eev8fef8eev8AgP8dfP8fev8gev8ffP8gef8fev8eev8fef8gev8AgP8fev8fev8zZv8gev8gev8eev8fef8eef8fe/8fev8fev8fef8fev8eev8fev8fev8id/8fev8XdP8fev8ge/8gev8fev8fev8agP8fef8fe/8gev8fev8fev8fev8kgP8fev8fev8fe/8ge/8hfP8fe/8fev8fev8fe/8cfP8agP8fev8ggP8ief8fev8fev8feP8fev8hev8fe/8ccf8fev8fev8fev8eev8fev8ge/8gev8fev8fev8eev8eeP8ee/8fev8kbf8gdf8eev8fev8ce/8hd/8cff8fe/8ge/8fef8fev8gef8eev8fev8id/8ee/8fev8eev8AVf8gev8def8geP8fev8he/8fe/8fev8fev8fev8bef8fev8AAABDbjZCAAAAjHRSTlMAFlN/p83e7vqmfhU0jtP+0o0zDXLV1HEMEYDt7BABXulvAiPDwiFQ8VaLiASdowWysZ+kVFHw779iXOroD3sL63Awis8UfMzK4Pn4Dlqbmlknnvb1nCUK+wgmxxkx4y7QCf2C9Jf8V5nLyJgih8YHGOLlGy8tzol65l/Bvh5NhLADoU4gwB/n0aXdEyRlNkUAAAABYktHRACIBR1IAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAB3RJTUUH5AcOBSsEZCijjAAADQZJREFUeNrt3YtbVFUXx/ERE9DUETFS0XHI0gxfyBS7kHkBkSYQNbpwiQohA9OsLK1M7V62/+hX357XJ7Pc+8zZa62zOd/PP8D5sX7PnJkzZ9apVAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQDJWtax+bE1rW7vzaG9rXbN2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"/>
                </defs>
            </svg>
            @endif
            Filter
        </button>
        <div class="mt-4 filter-container__content hidden">
            <span>Type</span>
            @foreach (App\PostType::all() as $postType)
            <div class="d-flex align-items-center">
                <input type="checkbox" value="" id="post-type-{{ $postType->post_type }}">
                <label for="post-type-{{ $postType->post_type }}">
                    {{ $postType->post_type }}
                </label>
            </div>
            @endforeach
            <span>Sort By</span>
            <div class="d-flex align-items-center">
                <input type="radio" value="" id="post-sort-by-popularity">
                <label for="post-sort-by-popularity">
                    Popularity
                </label>
            </div>
            <div class="d-flex align-items-center">
                <input type="radio" value="" id="post-sort-by-time">
                <label for="post-sort-by-time">
                    Time
                </label>
            </div>
        </div>
    </div>
    @endif

</form>
