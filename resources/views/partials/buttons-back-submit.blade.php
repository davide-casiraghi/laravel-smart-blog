{{-- Submit --}}
    <button type="submit" class="btn btn-primary float-right">@lang('laravel-smart-blog::general.submit')</button>

{{-- Back --}}
    @if(empty($routeParameter))
        <a class="btn btn-outline-primary mr-2 float-right" href="{{ route($route) }}">@lang('laravel-smart-blog::general.back')</a>
    @else
        <a class="btn btn-outline-primary mr-2 float-right" href="{{ route($route, $routeParameter) }}">@lang('laravel-smart-blog::general.back')</a>
    @endif   
