@extends('layouts.app')

@section('title', 'Forum')

@section('links-in-head')

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

@include ('forum/partials.forum-helper-btn')

<div class="container-fluid forum">
    <div class="row px-5">
        @include("forum.partials.forum-left")
        <section class="col-12 col-md-9 col-lg-7 forum-content">
            <div class="forum-heading-img"></div>

            <form action="#" method="GET" class="forum-content__search">
                <a class="btn btn-lg btn-back" href="{{ App\CustomClass\URLManager::getBackURL(route('posts.index')) }}">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                    </svg>
                    Back
                </a>
                <div class="form-search">
                    <input type="text" class="form-control form-control-lg input-search" placeholder="Computer Science...">
                    <svg class="svg-search">
                        <use xlink:href="{{asset('assets/sprite.svg#icon-search')}}"></use>
                    </svg>
                </div>
            </form>

            <form class="post-create" action="{{ route('posts.store') }}" method="POST">
                <h5 class="font-weight-bold mb-5">Create a new post</h5>
                <p class="input-title">Post Type</p>
                <div class="input-content p-relative">
                    <button class="btn btn-lg btn-post-type @if(old('post-type') == 'Question') btn-selected @endif" type="button">Questsion</button>
                    <button class="btn btn-lg btn-post-type @if(old('post-type') == 'Discussion') btn-selected @endif" type="button">Discussion</button>

                    @error('post-type')
                    <span class="fs-1-4 ws-no-wrap p-absolute top-100 left-0 fc-red mt-1">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <p class="input-title">Title</p>
                <div class="input-content p-relative">
                    <input type="text" class="post-title" placeholder="Enter your post title here..." value="{{ old('post-title') }}" name="post-title" required>
                    @error('post-title')
                    <span class="fs-1-4 ws-no-wrap p-absolute top-100 right-0 fc-red mt-1">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <p class="input-title">Content</p>
                <div class="input-content p-relative">
                    <textarea name="post-content" class="post-content">{!! old('post-content') !!}</textarea>
                    @error('post-content')
                    <span class="fs-1-4 ws-no-wrap p-absolute top-100 right-0 fc-red mt-1">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <p class="input-title">Tags</p>
                <div class="input-content p-relative">
                    <div class="input-group select-container p-relative select-container-icon pb-0-5">
                        <svg class="select-container__icon">
                            <use xlink:href="{{asset('assets/sprite.svg#icon-search')}}"></use>
                        </svg>
                        <select class="custom-select" name="tags[]" multiple="multiple" id="tags" required>
                            @foreach (App\Tag::all() as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->tag }}</option>
                            @endforeach
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

                <input type="hidden" id="input-hidden-post-type" name="post-type">
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
            'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking',
            'table emoticons template paste help imagetools'
        ],
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
</script>

<script src="{{ asset('js/forum/forum.js') }}"></script>
<script src="{{ asset('js/forum/create.js') }}"></script>
@endsection
