@extends('laravel-smart-blog::blogs.layout')


@section('content')
    
    
    {{-- Category --}}
    <div class="row">
        @if(!empty($blog->show_category_title))
            <div class="col-12">
                <h2>{{$category->name}}</h2>
            </div>
        @endif
        @if(!empty($blog->show_category_subtitle))
            <div class="col-12">
                Category subtitle
            </div>
        @endif
        
        @if(!empty($blog->show_category_image))
            <div class="col-12 mt-3">
                <img class="img-fluid" alt="{{ $category->intro_image }}" src="/storage/images/categories_intro_images/thumb_{{ $category->intro_image }}">
            </div>
        @else
            <div class="col-12 mt-3">
                <div class="alert alert-warning" role="alert">
                    Image not found
                </div>
            </div>
        @endif
        
        @if(!empty($blog->show_category_description))
            <div class="col-12">
                {!!$category->description!!}
            </div>
        @endif
    </div>
    
    

    <div class="row">
        <div class="col-12">
            
        </div>
    </div>
    
    {{-- Posts --}}
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
