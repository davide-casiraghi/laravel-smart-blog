@extends('laravel-smart-blog::blogs.layout')


@section('content')
    <div class="container max-w-md px-0">
        <div class="row">
            <div class="col-12 col-sm-7">
                <h4>@lang('laravel-smart-blog::blog.blog_management')</h4>
            </div>    
            <div class="col-12 col-sm-5 mt-sm-0 text-right">
                <a class="btn btn-success create-new" href="{{ route('blogs.create') }}"><i class="fa fas fa-plus-circle"></i> @lang('laravel-smart-blog::blog.create_blog')</a>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-4">
                <p>{{ $message }}</p>
            </div>
        @endif

        {{-- List of blogs --}}
        <div class="blogsList my-4">
            @foreach ($blogs as $blog)
                <div class="row bg-white shadow-1 rounded mb-3 pb-2 pt-3 mx-1">
                    {{-- Title --}}
                        {{--<div class="col-12 py-1 title">
                            <h5 class="darkest-gray">{{ $category->translate('en')->name }}</h5>
                        </div>--}}
                        
                        <div class="col-12 py-1 title">
                            <h5 class="darkest-gray">{{ $blog->id }}</h5>
                        </div>
                    
                        
                    {{-- Buttons --}}
                        <div class="col-12 pb-2 action">
                            <form action="{{ route('blogs.destroy',$blog->id) }}" method="POST">

                                <a class="btn btn-primary float-right" href="{{ route('blogs.edit',$blog->id) }}">@lang('laravel-smart-blog::general.edit')</a>
                                <a class="btn btn-outline-primary mr-2 float-right" href="{{ route('blogs.show',$blog->id) }}">@lang('laravel-smart-blog::general.view')</a>
                                
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-link pl-0">@lang('laravel-smart-blog::general.delete')</button>
                            </form>
                        </div>
                </div>
                
            @endforeach    
        </div>
        
        {!! $blogs->links() !!}
    </div>

@endsection
