@extends('laravel-smart-blog::blogs.layout')


@section('content')
    <div class="row">
        <div class="col-12">
            <h2>{{$category->name}}</h2>
            
        </div>
    </div>
    
    @switch($blog->layout)
        @case(1)
            @include('laravel-smart-blog::partials.blogs.bootstrap-wall', [
                  'blog' => $blog,
                  'category' => $category,
                  'posts' => $posts,
                  'columnsBootstrapClass' => $columnsBootstrapClass,
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

@endsection
