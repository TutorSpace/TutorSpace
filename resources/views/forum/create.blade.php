@extends('layouts.app')

@section('title', 'Forum')

@section('links-in-head')
{{-- tinymec (rich editor) --}}
<script src="https://cdn.tiny.cloud/1/0g5x4ywp59ytu15qbexxmx02e1mxg5eudd75k8p0kicery2n/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
@endsection

@section('body-class')
bg-white-dark-4

@if(Auth::check() && Auth::user()->is_tutor)
bg-tutor select2-bg-tutor
@else
bg-student select2-bg-student
@endif

@endsection

@section('content')

@include('partials.nav')

@include ('forum.partials.forum-helper-btn')

<div class="container forum">
    <div class="row forum-row">
        @include("forum.partials.forum-left")
        <section class="col-12 col-md-9 col-lg-55-p forum-content">
            <div class="forum-heading-img"></div>

            @include('forum.partials.search')

            <form class="post-create" action="#" method="POST">
                <h5 class="font-weight-bold mb-5">Create a new post</h5>
                <p class="input-title">Post Type</p>
                <div class="input-content p-relative">
                    <button class="btn btn-lg btn-post-type @if(($oldPostData['post-type'] ?? $postDraft->post_type_id) == 1) btn-selected @endif" type="button" data-post-type-id=1>Question</button>
                    <button class="btn btn-lg btn-post-type @if(($oldPostData['post-type'] ?? $postDraft->post_type_id) == 2) btn-selected @endif" type="button" data-post-type-id=2>Note</button>
                    <button class="btn btn-lg btn-post-type @if(($oldPostData['post-type'] ?? $postDraft->post_type_id) == 3) btn-selected @endif" type="button" data-post-type-id=3>Other</button>

                    @error('post-type')
                    <span class="fs-1-4 ws-no-wrap p-absolute top-100 left-0 fc-red mt-1">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <p class="input-title">Title</p>
                <div class="input-content p-relative">
                    <input type="text" class="post-title" placeholder="Enter your post title here..." value="{{ $oldPostData['post-title'] ?? $postDraft->title }}" name="post-title" required>
                    @error('post-title')
                    <span class="fs-1-4 ws-no-wrap p-absolute top-100 right-0 fc-red mt-1">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <p class="input-title">Content</p>
                <div class="input-content p-relative">
                    <textarea name="post-content" class="post-content">{!! $oldPostData['post-content'] ?? $postDraft->content !!}</textarea>
                    @error('post-content')
                    <span class="fs-1-4 ws-no-wrap p-absolute top-100 right-0 fc-red mt-1">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <p class="input-title">Tags</p>
                <div class="input-content p-relative tags-container">
                    <div class="input-group select-container p-relative select-container-icon">
                        <svg class="select-container__icon">
                            <use xlink:href="{{asset('assets/sprite.svg#icon-search')}}"></use>
                        </svg>
                        <select class="custom-select" name="tags[]" multiple="multiple" id="create-tags" required>
                        </select>
                        <div class="input-group-prepend">
                            <svg>
                                <use xlink:href="{{asset('assets/sprite.svg#icon-keyboard_arrow_down')}}"></use>
                            </svg>
                        </div>
                    </div>
                    @error('tags')
                    <span class="fs-1-4 ws-no-wrap p-absolute top-100 right-0 fc-red mt-1">
                        {{ $message }}
                    </span>
                    @enderror
                    @error('tags.*')
                    <span class="fs-1-4 ws-no-wrap p-absolute top-100 right-0 fc-red mt-1">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-lg btn-save btn-animation-y">Save as Draft</button>
                    <button class="btn btn-lg btn-create btn-animation-y">Create Post</button>
                </div>

                <input type="hidden" id="input-hidden-post-type" name="post-type" value="{{ $oldPostData['post-type'] ?? $postDraft->post_type_id}}">
                @csrf
            </form>


        </section>

        @include("forum.partials.forum-right")
    </div>
</div>

@include('partials.footer')

@endsection

@section('js')

@include('partials.nav-auth-js')


<script>
    tinymce.init({
        selector: 'textarea',  // change this value according to your HTML
        plugins: [
            'advlist autolink link image lists charmap print preview hr spellchecker',
            'wordcount fullscreen insertdatetime',
            'table emoticons paste help imagetools',
            'codesample'
        ],
        toolbar: 'undo redo | bold italic | image link codesample | numlist bullist checklist | fontselect fontsizeselect formatselect | charmap emoticons | preview save print | alignleft aligncenter alignright alignjustify | outdent indent',
        // remove_linebreaks : true,
        height: 300,
        a_plugin_option: true,
        a_configuration_option: 400,
        // images_upload_base_path: '/some/basepath',
        images_upload_handler: function(blobInfo, success, failure) {
            var xhr, formData;

            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', "{{ route('upload-post-img') }}");
            xhr.setRequestHeader("X-CSRF-Token", $('meta[name="csrf-token"]').attr('content'));

            xhr.onload = function() {
                var json;

                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }

                json = JSON.parse(xhr.responseText);

                if(json.errorMsg) {
                    failure('Error: ' + json.errorMsg);
                    console.log(json.errorMsg);
                }
                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                success(json.location);
            };

            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
            return true;
        },
    });

    $('.btn-save').click(function() {
        $('.post-create').attr('action', '{{ route('post-draft.store') }}');
    });
    $('.btn-create').click(function() {
        $('.post-create').attr('action', '{{ route('posts.store') }}');
    })
</script>

<script src="{{ asset('js/forum/forum.js') }}"></script>
<script src="{{ asset('js/forum/create.js') }}"></script>
@endsection
