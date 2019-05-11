@extends('laravel-smart-blog::layout')

@section('title',  "Blogs" )

@section('content')

    <div class="container">

		<div class="container">
		    @yield('content')
		</div>

    </div>

@endsection
