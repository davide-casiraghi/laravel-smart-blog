@extends('laravel-smart-blog::blogTranslations.layout')

@section('content')
    <div class="container max-w-md px-0">
        <div class="row py-4">
            <div class="col-12 col-sm-9">
                <h4>@lang('views.add_new_translation')</h4>
            </div>
            <div class="col-12 col-sm-3 text-right">
                <span class="badge badge-secondary">{{$selectedLocaleName}}</span>
            </div>
        </div>

        @include('laravel-smart-blog::partials.error-management', [
              'style' => 'alert-danger',
        ])

        <form action="{{ route('blogTranslations.store') }}" method="POST">
            @csrf

                @include('laravel-smart-blog::partials.input-hidden', [
                      'name' => 'blog_id',
                      'value' => $blogId,
                ])
                @include('laravel-smart-blog::partials.input-hidden', [
                      'name' => 'language_code',
                      'value' => $languageCode
                ])

             <div class="row">
                <div class="col-12">
                    @include('laravel-smart-blog::partials.input', [
                        'title' => 'Name',
                        'name' => 'name',
                        'placeholder' => 'Category name',
                        'value' => old('name'),
                        'required' => true,
                    ])
                </div>
                
                <div class="col-12">
                    @include('laravel-smart-blog::partials.textarea', [
                          'title' => __('general.description'),
                          'name' => 'description',
                          'placeholder' => 'Description',
                          'value' => old('description'),
                          'required' => false,
                    ])
                </div>
            </div>

            <div class="row mt-2">  
                <div class="col-12 action">
                    @include('laravel-smart-blog::partials.buttons-back-submit', [
                        'route' => 'blogs.index'  
                    ])
                </div>
            </div>

        </form>
    </div>

@endsection
