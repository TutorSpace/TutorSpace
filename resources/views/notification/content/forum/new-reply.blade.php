<div class="notification__content__header font-weight-bold">
    @if ($forFollowers)
    There is a new reply in a post you followed
    @else
    There is a new reply in your post
    @endif
</div>
<div class="notification__content__info">

    <div class="notification__content__info__wrapper">
        <div class="notification__content__info__header bg-primary"></div>

        <div class="container content">
            <h6 class=" text-center">
                @if ($forFollowers)
                There is a new reply in a post you followed.
                @else
                There is a new reply in your post.
                @endif
            </h6>

            <div class="quote">
                <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.112 0.0159998H7.76L4.544 11.536H0.176L4.112 0.0159998ZM13.088 0.0159998H16.736L13.52 11.536H9.152L13.088 0.0159998Z" fill="black"/>
                </svg>
                <p>
                    {{ $content }}
                </p>
                <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.112 0.0159998H7.76L4.544 11.536H0.176L4.112 0.0159998ZM13.088 0.0159998H16.736L13.52 11.536H9.152L13.088 0.0159998Z" fill="black"/>
                </svg>
            </div>

            <p class="fc-grey fs-1-6 text-center">To view the post, click on the link below <br />
                <a class="color-primary" href="{{ route('posts.show', $post) }}" target="_blank">{{ route('posts.show', $post) }}</a>
            </p>
        </div>
    </div>

    {{-- <p class="fc-grey text-center mt-5 fs-1-6">TutorSpace Team <br /> Email: <a class="color-primary" href="mailto:tutorspaceusc@gmail.com">tutorspaceusc@gmail.com</a></p> --}}
</div>
