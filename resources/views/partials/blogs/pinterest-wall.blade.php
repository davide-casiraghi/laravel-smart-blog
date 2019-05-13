<div class="blogBricklayer bricklayer" id='my-bricklayer' data-column-width='{{$blog->columns_width}}' data-gutter='20'>
    @foreach ($posts as $key => $post)
        <div class='box'>
            <h4>{{ $post->title }}</h4>
        
            @if(!empty($post->introimage))
                <img class="img-fluid" alt="{{ $post->title }}" src="/storage/images/posts_intro_images/thumb_{{ $post->introimage }}">
            @else
                <div class="alert alert-warning" role="alert">
                    Image not found
                </div>
            @endif
            
            {!!$post->intro_text!!}
        </div>
    @endforeach
</div>
