@extends('laravel-smart-blog::blogs.layout')

@section('content')
    <div class="container max-w-md px-0">
    
        <div class="row mb-4">
            <div class="col-12">
                <h3>@lang('laravel-smart-blog::blog.create_blog')</h3>
            </div>
        </div>

        @include('laravel-smart-blog::partials.error-management', [
              'style' => 'alert-danger',
        ])

        <form action="{{ route('blogs.store') }}" method="POST">
            @csrf

             <div class="row">
                 {{-- Blog name --}}
                 <div class="col-12">
                     @include('laravel-smart-blog::partials.input', [
                           'title' => __('laravel-smart-blog::blog.name'),
                           'name' => 'name',
                           'placeholder' => '',
                           'value' => old('name'),
                           'required' => true,
                     ])
                 </div>
                 
                 {{-- category_id --}}
                 <div class="col-12">
                    @include('laravel-smart-blog::partials.select', [
                          'title' => __('laravel-smart-blog::blog.category'),
                          'name' => 'category_id',
                          'placeholder' => __('general.select_category'),
                          'records' => $categories,
                          'liveSearch' => 'false',
                          'mobileNativeMenu' => true,
                          'selected' => old('category_id'),
                          'required' => true,
                    ])
                </div>
                
                {{-- layout --}}
                <div class="col-12">
                   @include('laravel-smart-blog::partials.select', [
                         'title' => __('laravel-smart-blog::blog.layout'),
                         'name' => 'layout',
                         'placeholder' => __('general.select_layout'),
                         'records' => [
                             '1' => 'Bootstrap Wall',
                             '2' => 'Pinterest Wall',
                         ],
                         'liveSearch' => 'false',
                         'mobileNativeMenu' => true,
                         'selected' => old('layout'),
                         'required' => true,
                   ])
               </div>
                   
                {{-- columns_number --}}
                <div class="col-12">
                   @include('laravel-smart-blog::partials.select', [
                         'title' => __('laravel-smart-blog::blog.columns_number'),
                         'name' => 'columns_number',
                         'placeholder' => __('laravel-smart-blog::general.select_one'),
                         'records' => [
                             '1' => '1',
                             '2' => '2',
                             '3' => '3',
                             '4' => '4',
                         ],
                         'liveSearch' => 'false',
                         'mobileNativeMenu' => true,
                         'selected' => old('columns_number'),
                         'required' => true,
                   ])
               </div>
               
               {{-- columns_width --}}
               <div class="col-12">
                   @include('laravel-smart-blog::partials.input', [
                         'title' => __('laravel-smart-blog::blog.columns_width'),
                         'name' => 'columns_width',
                         'placeholder' => 'number like 200 or 400',
                         'value' => old('columns_width'),
                         'required' => true,
                   ])
               </div>
                
                {{-- article_order --}}
                <div class="col-12">
                   @include('laravel-smart-blog::partials.select', [
                         'title' =>  __('laravel-smart-blog::blog.article_order'),
                         'name' => 'article_order',
                         'placeholder' => __('general.select_layout'),
                         'records' => [
                             '1' => 'Most recent first',
                             '2' => 'Older first',
                             '3' => 'Title alphabetical',
                             '4' => 'Author alphabetical',
                             '5' => 'Most hits',
                             '6' => 'Random order',
                             '7' => 'Article order',
                         ],
                         'liveSearch' => 'false',
                         'mobileNativeMenu' => true,
                         'selected' => old('article_order'),
                         'required' => true,
                   ])
               </div>
               
                {{-- items_per_page --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.input', [
                          'title' => __('laravel-smart-blog::blog.items_per_page'),
                          'name' => 'items_per_page',
                          'placeholder' => 'Items per page',
                          'value' => old('items_per_page'),
                          'required' => true,
                    ])
                </div>
                
                {{-- featured_articles --}}
                <div class="col-12">
                   @include('laravel-smart-blog::partials.select', [
                         'title' => __('laravel-smart-blog::blog.featured_articles'),
                         'name' => 'featured_articles',
                         'placeholder' => __('general.select_layout'),
                         'records' => [
                             '1' => 'Show',
                             '2' => 'Hide',
                             '3' => 'Only',
                         ],
                         'liveSearch' => 'false',
                         'mobileNativeMenu' => true,
                         'selected' => old('featured_articles'),
                         'required' => true,
                   ])
               </div>
               
                {{-- show_category_title --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'show_category_title',
                          'description' => __('laravel-smart-blog::blog.show_category_title'),
                          'value' => old('show_category_title'),
                          'required' => false,
                    ])
                </div>
                {{-- show_category_subtitle --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'show_category_subtitle',
                          'description' => __('laravel-smart-blog::blog.show_category_subtitle'),
                          'value' => old('show_category_subtitle'),
                          'required' => false,
                    ])
                </div>
                {{-- show_category_description --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'show_category_description',
                          'description' => __('laravel-smart-blog::blog.show_category_description'),
                          'value' => old('show_category_description'),
                          'required' => false,
                    ])
                </div>
                {{-- show_category_image --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'show_category_image',
                          'description' => __('laravel-smart-blog::blog.show_category_image'),
                          'value' => old('show_category_image'),
                          'required' => false,
                    ])
                </div>
                {{-- show_post_title --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'show_post_title',
                          'description' => __('laravel-smart-blog::blog.show_post_title'),
                          'value' => old('show_post_title'),
                          'required' => false,
                    ])
                </div>
                {{-- post_linked_titles --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'post_linked_titles',
                          'description' => __('laravel-smart-blog::blog.post_linked_titles'),
                          'value' => old('post_linked_titles'),
                          'required' => false,
                    ])
                </div>
                {{-- show_post_intro_text --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'show_post_intro_text',
                          'description' => __('laravel-smart-blog::blog.show_post_intro_text'),
                          'value' => old('show_post_intro_text'),
                          'required' => false,
                    ])
                </div>
                {{-- show_post_author --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'show_post_author',
                          'description' => __('laravel-smart-blog::blog.show_post_author'),
                          'value' => old('show_post_author'),
                          'required' => false,
                    ])
                </div>
                
                {{-- link_post_author --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'link_post_author',
                           'description' => __('laravel-smart-blog::blog.link_post_author'),
                          'value' => old('link_post_author'),
                          'required' => false,
                    ])
                </div>
                
                {{-- show_create_date --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'show_create_date',
                         'description' => __('laravel-smart-blog::blog.show_create_date'),
                          'value' => old('show_create_date'),
                          'required' => false,
                    ])
                </div>
                
                {{-- show_modify_date --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'show_modify_date',
                          'description' => __('laravel-smart-blog::blog.show_modify_date'),
                          'value' => old('show_modify_date'),
                          'required' => false,
                    ])
                </div>
                
                {{-- show_publish_date --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'show_publish_date',
                          'description' => __('laravel-smart-blog::blog.show_publish_date'),
                          'value' => old('show_publish_date'),
                          'required' => false,
                    ])
                </div>
                
                {{-- show_read_more --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'show_read_more',
                          'description' => __('laravel-smart-blog::blog.show_read_more'),
                          'value' => old('show_read_more'),
                          'required' => false,
                    ])
                </div>
                
            </div>

            <div class="row">
               <div class="col-12 mt-3 mb-4">
                    @include('laravel-smart-blog::partials.buttons-back-submit', [
                        'route' => 'blogs.index'  
                    ])
                </div>
            </div>

        </form>
    </div>
@endsection
