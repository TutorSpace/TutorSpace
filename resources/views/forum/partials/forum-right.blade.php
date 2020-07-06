<section class="col-3 forum-right">
    <a class="btn btn-lg btn-add-post btn-animation-y" href="#">
        <svg class="mr-2" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5H4a.5.5 0 0 1 0-1h3.5V4a.5.5 0 0 1 .5-.5z"/>
            <path fill-rule="evenodd" d="M7.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0V8z"/>
        </svg>
        Add A New Post
    </a>

    <section class="trending-tags">
        <h5 class="trending-tags__heading">
            <svg class="svg-trending-tag mr-2">
                <use xlink:href="{{asset('assets/sprite.svg#icon-search')}}"></use>
            </svg>
            Trending Tags
        </h5>

        <table class="trending-tags__list table">
            <thead>
                <tr>
                    <th scope="col">&nbsp;Tag</th>
                    <th scope="col">Post</th>
                    <th scope="col">Reply</th>
                </tr>
            </thead>
            <tbody>
                <tr class="trending-tags__list-item mb-3">
                    <th>
                        <a class="tag-name" href="">#Computer Science</a>
                    </th>
                    <td class="post-cnt">2830</td>
                    <td class="reply-cnt">487</td>
                </tr>
                <tr class="trending-tags__list-item mb-3">
                    <th>
                        <a class="tag-name" href="">#Science</a>
                    </th>
                    <td class="post-cnt">283</td>
                    <td class="reply-cnt">47</td>
                </tr>
                <tr class="trending-tags__list-item mb-3">
                    <th>
                        <a class="tag-name" href="">#Mathematics</a>
                    </th>
                    <td class="post-cnt">283</td>
                    <td class="reply-cnt">487</td>
                </tr>
                <tr class="trending-tags__list-item mb-3">
                    <th>
                        <a class="tag-name" href="">#Business Administration</a>
                    </th>
                    <td class="post-cnt">283</td>
                    <td class="reply-cnt">487</td>
                </tr>
                <tr class="trending-tags__list-item mb-3">
                    <th>
                        <a class="tag-name" href="">#Design</a>
                    </th>
                    <td class="post-cnt">2</td>
                    <td class="reply-cnt">4</td>
                </tr>
            </tbody>
        </table>

        <p class="fs-1-4 bottom-0 right-0 fc-grey my-0 text-right">
            Last Updated at 2020/07/05
        </p>
    </section>

    <div class="forum-heading-img mt-5"></div>

    <div class="you-may-help-with">
        <h5 class="you-may-help-with__heading">
            <svg class="svg-trending-tag mr-2">
                <use xlink:href="{{asset('assets/sprite.svg#icon-search')}}"></use>
            </svg>
            You may help with...
        </h5>
        <div class="questions">
            <a href="#" class="question">Lorem ipsum dolor sit amet consectetur adipisicing elit?</a>
            <a href="#" class="question">Lorem ipsum dolor sit amet consectetur adipisicing elit aperiam?</a>
            <a href="#" class="question">Lorem ipsum dolor sit amet consectetur adipisicing  aperiam?</a>
            <a href="#" class="question">Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti ipsum aperiam?</a>
            <a href="#" class="question">Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti ipsum aperiam?</a>
        </div>

        <p class="fs-1-4 bottom-0 right-0 fc-grey mt-4 mb-0 text-right">
            <a href="#" class="btn-link">View All</a>
        </p>
    </div>

</section>
