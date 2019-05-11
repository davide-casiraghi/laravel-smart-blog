@extends('laravel-smart-blog::blogs.layout')


@section('content')
    <div class="container max-w-md px-0">
    
        <div class="row mb-4">
            <div class="col-12 col-sm-10">
                <h3>@lang('views.add_new_category')</h3>
            </div>
            <div class="col-12 col-sm-2 text-right">
                <span class="badge badge-secondary">English</span>
            </div>
        </div>

        @include('laravel-smart-blog::partials.error-management', [
              'style' => 'alert-danger',
        ])

        <form action="{{ route('categories.store') }}" method="POST">
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
                          'seleted' => old('category_id'),
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
                                 '1' => 'layout_1',
                                 '2' => 'layout_2',
                             ],
                             'liveSearch' => 'false',
                             'mobileNativeMenu' => true,
                             'seleted' => old('layout'),
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
                         'seleted' => old('columns'),
                         'required' => true,
                   ])
               </div>
                
                {{-- article_order --}}
                
                {{-- pagination --}}
                {{-- featured_articles --}}
                {{-- show_category_title --}}
                {{-- show_category_subtitle --}}
                {{-- show_category_description --}}
                {{-- show_category_image --}}
                {{-- show_post_title --}}
                {{-- post_linked_titles --}}
                {{-- show_post_intro_text --}}
                {{-- show_post_author --}}
                {{-- link_post_author --}}
                {{-- show_create_date --}}
                {{-- show_modify_date --}}
                {{-- show_publish_date --}}
                {{-- show_read_more --}}
                <div class="col-12">
                    @include('laravel-smart-blog::partials.checkbox', [
                          'name' => 'show_read_more',
                          'description' => __('views.blogs.show_read_more'),
                          'value' => '',
                          'required' => false,
                    ])
                </div>
                
                
                
                
                
                
                
                <div class="col-12">
                    @include('laravel-smart-blog::partials.input', [
                          'title' => __('general.name'),
                          'name' => 'name',
                          'placeholder' => 'Category name',
                          'required' => true,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-smart-blog::partials.textarea', [
                          'title' => __('general.description'),
                          'name' => 'description',
                          'placeholder' => 'Description',
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
