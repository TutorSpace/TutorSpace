<section class="view-profile__forum">
    <div class="filter">
       <h6>Top Rated Posts</h6>
       <select name="" id="forum-post-order-options">
       <option value="{{route('view.profile', ['user'=> $user, 'orderByOption' => 'popularity'])}}" {{$orderByOption == "popularity" ? "selected":""}}>Sort by Popularity</option>
           <option value="{{route('view.profile', ['user'=> $user, 'orderByOption' => 'timeAsc'])}}" {{$orderByOption == "timeAsc" ? "selected":""}}>Sort by Time (Oldest)</option>
           <option value="{{route('view.profile', ['user'=> $user, 'orderByOption' => 'timeDesc'])}}" {{$orderByOption == "timeDesc" ? "selected":""}}>Sort by Time (Latest)</option>
       </select>
    </div>
    <div class="post-previews">
        @include('forum.partials.post-preview-general', [
            'posts' => $posts
        ])
        {{ $posts->withQueryString()->links() }}
    </div>
</section>
