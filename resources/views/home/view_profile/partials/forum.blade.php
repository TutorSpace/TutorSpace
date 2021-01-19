<section class="view-profile__forum">
    <div class="filter">
       <h6>Top Rated Posts</h6>
       <select id="forum-post-order-options">
            <option value="popularity" {{$orderByOption == "popularity" ? "selected":""}}>Sort by Popularity</option>
            <option value="timeDesc" {{$orderByOption == "timeDesc" ? "selected":""}}>Sort by Time (Latest)</option>
           <option value="timeAsc" {{$orderByOption == "timeAsc" ? "selected":""}}>Sort by Time (Earliest)</option>
       </select>
    </div>
    <div class="post-previews">
        @include('forum.partials.post-preview-general', [
            'posts' => $posts
        ])
        {{ $posts->withQueryString()->links() }}
    </div>
</section>
