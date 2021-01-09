<section class="view-profile__forum">
    <div class="filter">
       <h5>Top Rated Posts</h5>
       <select name="" id="">
           <option value="">Sort by Popularity</option>
           <option value="">Sort by Time (Ascending)</option>
           <option value="">Sort by Time (Descending)</option>
       </select>
    </div>
    <div class="post-previews">
        @include('forum.partials.post-preview-general', [
            'posts' => $posts
        ])
        {{ $posts->withQueryString()->links() }}
    </div>
</section>
