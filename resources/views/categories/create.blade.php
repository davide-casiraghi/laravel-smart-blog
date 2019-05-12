@extends('laravel-smart-blog::categories.layout')


@section('content')
    <div class="container max-w-md px-0">
    
        <div class="row mb-4">
            <div class="col-12 col-sm-10">
                <h3>@lang('laravel-smart-blog::category.create_category')</h3>
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

             <div class="row">
                <div class="col-12">
                    @include('laravel-smart-blog::partials.input', [
                          'title' => __('laravel-smart-blog::general.name'),
                          'name' => 'name',
                          'placeholder' => 'Category name',
                          'required' => true,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-smart-blog::partials.textarea', [
                          'title' => __('laravel-smart-blog::general.description'),
                          'name' => 'description',
                          'placeholder' => 'Description',
                          'required' => false,
                    ])
                </div>
            </div>

            <div class="row">
               <div class="col-12 mt-3 mb-4">
                    @include('laravel-smart-blog::partials.buttons-back-submit', [
                        'route' => 'categories.index'  
                    ])
                </div>
            </div>

        </form>
    </div>
@endsection
