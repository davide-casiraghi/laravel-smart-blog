@extends('laravel-smart-blog::blogs.layout')


@section('content')
    <div class="container max-w-md px-0">
    
        <div class="row mb-4">
            <div class="col-12 col-sm-6">
                <h3>@lang('views.edit_category')</h3>
            </div>
            <div class="col-12 col-sm-6 text-right">
                <span class="badge badge-secondary">English</span>
            </div>
        </div>

        @include('laravel-smart-blog::partials.error-management', [
            'style' => 'alert-danger',
        ])

        <form action="{{ route('blogs.update',$category->id) }}" method="POST">
            @csrf
            @method('PUT')

             <div class="row">
                <div class="col-12">
                    @include('laravel-smart-blog::partials.input', [
                          'title' => __('general.name'),
                          'name' => 'name',
                          'placeholder' => 'Category name',
                          'value' => $category->translate('en')->name,
                          'required' => true,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-smart-blog::partials.textarea', [
                          'title' => __('general.description'),
                          'name' => 'description',
                          'placeholder' => 'Description',
                          'value' => $category->translate('en')->description,
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