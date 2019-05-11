@extends('laravel-smart-blog::blogs.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Show Blog</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('blogs.index') }}"> Back</a>
            </div>
        </div>
    </div>
    
    @switch($blog->layout)
        @case(1)
            @include('laravel-smart-blog::partials.blogs.bootstrap-wall', [
                  'blog' => $blog,
                  'category' => $category,
                  'posts' => $posts,
            ])
        @break

        @case(2)
            @include('laravel-smart-blog::partials.blogs.pinterest-wall', [
              'blog' => $blog,
              'category' => $category,
              'posts' => $posts,
          ])
        @break

    @endswitch
{{--
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $category->name }}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <strong>Slug:</strong>
                {{ $category->slug }}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <strong>Description:</strong>
                {{ $category->description }}
            </div>
        </div>
    </div>
    --}}
@endsection
