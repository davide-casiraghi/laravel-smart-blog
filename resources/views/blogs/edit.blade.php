@extends('laravel-smart-blog::blogs.layout')

@section('content')
    <div class="container max-w-md px-0">
        
        <div class="row mb-4">
            <div class="col-12">
                <h3>@lang('views.edit_blog')</h3>
            </div>
        </div>

        @include('laravel-smart-blog::partials.error-management', [
              'style' => 'alert-danger',
        ])

        <form action="{{ route('blogs.store') }}" method="POST">
            @csrf

            {{-- category_id --}}
             <div class="row">
                 <div class="col-12">
                    @include('laravel-smart-blog::partials.select', [
                          'title' => __('general.category'),
                          'name' => 'category_id',
                          'placeholder' => __('general.select_category'),
                          'records' => $categories,
                          'liveSearch' => 'false',
                          'mobileNativeMenu' => true,
                          'selected' => $blog->category_id,
                          'required' => true,
                    ])
                </div>
                
                {{-- layout --}}
                    <div class="col-12">
                       @include('laravel-smart-blog::partials.select', [
                             'title' => __('general.layout'),
                             'name' => 'layout',
                             'placeholder' => __('general.select_layout'),
                             'records' => [
                                 '1' => 'Bootstrap Wall',
                                 '2' => 'Pinterest Wall',
                             ],
                             'liveSearch' => 'false',
                             'mobileNativeMenu' => true,
                             'selected' => $blog->layout,
                             'required' => true,
                       ])
                   </div>
                   
                {{-- columns --}}
                <div class="col-12">
                   @include('laravel-smart-blog::partials.select', [
                         'title' => __('general.columns'),
                         'name' => 'columns',
                         'placeholder' => __('general.select_layout'),
                         'records' => [
                             '1' => '1',
                             '2' => '2',
                             '3' => '3',
                             '4' => '4',
                         ],
                         'liveSearch' => 'false',
                         'mobileNativeMenu' => true,
                         'selected' => $blog->columns,
                         'required' => true,
                   ])
               </div>
                
                {{-- article_order --}}
                <div class="col-12">
                   @include('laravel-smart-blog::partials.select', [
                         'title' => __('general.article_order'),
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
                         'selected' => $blog->article_order,
                         'required' => true,
                   ])
               </div>
               
                {{-- pagination --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.input', [
                          'title' => __('general.pagination'),
                          'name' => 'pagination',
                          'placeholder' => 'Items per page',
                          'value' => $blog->pagination,
                          'required' => true,
                    ])
                </div>
                
                {{-- featured_articles --}}
                <div class="col-12">
                   @include('laravel-smart-blog::partials.select', [
                         'title' => __('general.featured_articles'),
                         'name' => 'featured_articles',
                         'placeholder' => __('general.select_layout'),
                         'records' => [
                             '1' => 'Show',
                             '2' => 'Hide',
                             '3' => 'Only',
                         ],
                         'liveSearch' => 'false',
                         'mobileNativeMenu' => true,
                         'selected' => $blog->featured_articles,
                         'required' => true,
                   ])
               </div>
               
                {{-- show_category_title --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'show_category_title',
                          'description' => __('views.blogs.show_category_title'),
                          'value' => $blog->show_category_title,
                          'required' => false,
                    ])
                </div>
                {{-- show_category_subtitle --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'show_category_subtitle',
                          'description' => __('views.blogs.show_category_subtitle'),
                          'value' => $blog->show_category_subtitle,
                          'required' => false,
                    ])
                </div>
                {{-- show_category_description --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'show_category_description',
                          'description' => __('views.blogs.show_category_description'),
                          'value' => $blog->show_category_description,
                          'required' => false,
                    ])
                </div>
                {{-- show_category_image --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'show_category_image',
                          'description' => __('views.blogs.show_category_image'),
                          'value' => $blog->show_category_image,
                          'required' => false,
                    ])
                </div>
                {{-- show_post_title --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'show_post_title',
                          'description' => __('views.blogs.show_post_title'),
                          'value' => $blog->show_post_title,
                          'required' => false,
                    ])
                </div>
                {{-- post_linked_titles --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'post_linked_titles',
                          'description' => __('views.blogs.post_linked_titles'),
                          'value' => $blog->post_linked_titles,
                          'required' => false,
                    ])
                </div>
                {{-- show_post_intro_text --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'show_post_intro_text',
                          'description' => __('views.blogs.show_post_intro_text'),
                          'value' => $blog->show_post_intro_text,
                          'required' => false,
                    ])
                </div>
                {{-- show_post_author --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'show_post_author',
                          'description' => __('views.blogs.show_post_author'),
                          'value' => $blog->show_post_author,
                          'required' => false,
                    ])
                </div>
                
                {{-- link_post_author --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'link_post_author',
                          'description' => __('views.blogs.link_post_author'),
                          'value' =>  $blog->link_post_author,
                          'required' => false,
                    ])
                </div>
                
                {{-- show_create_date --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'show_create_date',
                          'description' => __('views.blogs.show_create_date'),
                          'value' => $blog->show_create_date,
                          'required' => false,
                    ])
                </div>
                
                {{-- show_modify_date --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'show_modify_date',
                          'description' => __('views.blogs.show_modify_date'),
                          'value' => $blog->show_modify_date,
                          'required' => false,
                    ])
                </div>
                
                {{-- show_publish_date --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'show_publish_date',
                          'description' => __('views.blogs.show_publish_date'),
                          'value' => $blog->show_publish_date,
                          'required' => false,
                    ])
                </div>
                
                {{-- show_read_more --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'show_read_more',
                          'description' => __('views.blogs.show_read_more'),
                          'value' => $blog->show_read_more,
                          'required' => false,
                    ])
                </div>
                
            </div>

            @include('laravel-smart-blog::partials.buttons-back-submit', [
                'route' => 'blogs.index'  
            ])

        </form>
    </div>
@endsection
