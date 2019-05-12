@extends('laravel-smart-blog::posts.layout')


@section('content')
    <div class="container max-w-md px-0">
    
        <div class="row mb-4">
            <div class="col-12 col-sm-8">
                <h3>@lang('laravel-smart-blog::post.create_post')</h3>
            </div>
            <div class="col-12 col-sm-4 text-right">
                <span class="badge badge-secondary">English</span>
            </div>
        </div>

        @include('laravel-smart-blog::partials.error-management', [
              'style' => 'alert-danger',
        ])

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

             <div class="row">
                <div class="col-12">
                    @include('laravel-smart-blog::partials.input', [
                        'title' => __('laravel-smart-blog::post.title'),
                        'name' => 'title',
                        'placeholder' => 'Post title',
                        'value' => old('title'),
                        'required' => true,
                    ])
                </div>
                
                <div class="col-12">
                    @include('laravel-smart-blog::partials.select', [
                        'title' => __('laravel-smart-blog::post.category'),
                        'name' => 'category_id',
                        'placeholder' => __('views.select_category'),
                        'records' => $categories,
                        'liveSearch' => 'false',
                        'mobileNativeMenu' => true,
                        'required' => true,
                    ])
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>@lang('laravel-smart-blog::post.status')</strong>
                        <select name="status" class="form-control">
                            <option value="2" selected>Published</option>
                            <option value="1">Unpublished</option>
                        </select>

                    </div>
                </div>
                <div class="col-12">
                    @include('laravel-smart-blog::partials.textarea-plain', [
                        'title' =>  __('laravel-smart-blog::post.before_post_contents'),
                        'name' => 'before_content',
                        'value' => old('before_content'),
                        'required' => false,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-smart-blog::partials.textarea-post', [
                        'title' => __('laravel-smart-blog::post.text'),
                        'name' => 'body',
                        'placeholder' => 'Post text',
                        'value' => old('body'),
                        'required' => true,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-smart-blog::partials.textarea-plain', [
                        'title' =>  __('laravel-smart-blog::post.after_post_contents'),
                        'name' => 'after_content',
                        'value' => old('after_content'),
                        'required' => false,
                    ])
                </div>
                
                @include('laravel-smart-blog::partials.upload-image', [
                      'title' => __('laravel-smart-blog::post.upload_post_image'), 
                      'name' => 'introimage',
                      'folder' => 'posts_intro_images',
                      'value' => ''
                ])
            </div>

            <div class="row">
               <div class="col-12 mt-3 mb-4">
                    @include('laravel-smart-blog::partials.buttons-back-submit', [
                        'route' => 'posts.index'  
                    ])
                </div>
            </div>

            <input type="hidden" name="featured" value="0">

        </form>
    </div>
@endsection
