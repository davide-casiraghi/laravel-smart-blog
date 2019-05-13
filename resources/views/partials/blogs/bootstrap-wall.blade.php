{{-- eg. https://www.oldvictoriannew.com/ --}}

<div class="row">
        
    @foreach ($posts as $key => $post)
        <div class="col-12 col-sm-6 {{$columnsBootstrapClass}} mb-5">
            @if(!empty($blog->show_post_title))
                @if(!empty($blog->post_linked_titles))
                    <h4><a href="{{ route('posts.show',$post->id) }}">{{ $post->title }}</a></h4>
                @else
                    <h4>{{ $post->title }}</h4>
                @endif
            @endif
            
            
        
            @if(!empty($post->introimage))
                <img class="img-fluid" alt="{{ $post->title }}" src="/storage/images/posts_intro_images/thumb_{{ $post->introimage }}">
            @else
                <div class="alert alert-warning" role="alert">
                    Image not found
                </div>
            @endif
            
            @if(!empty($blog->show_post_intro_text))
                {!!$post->intro_text!!}
            @endif
            
            @if(!empty($blog->show_read_more))
                <br>
                <a href="{{ route('posts.show',$post->id) }}">@lang('laravel-smart-blog::blog.read_more')</a>
            @endif
            
            
        </div>
    @endforeach

</div>
