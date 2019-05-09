@extends('laravel-smart-blog::layout')

@section('title',  "Posts" )

@section('content')

    <div class="container">

		<div class="container">
		    @yield('content')
		</div>

    </div>

@endsection
