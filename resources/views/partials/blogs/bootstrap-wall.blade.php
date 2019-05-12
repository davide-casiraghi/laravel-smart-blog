{{-- eg. https://www.oldvictoriannew.com/ --}}

<div class="row">
        
    @foreach ($posts as $key => $post)
        <div class="col-12 {{$columnsBootstrapClass}}">
            <h4>{{ $post->title }}</h4>
        
            @if(!empty($post->image))
                <img class="ml-sm-3 float-sm-right img-fluid" alt="{{ $post->title }}" src="/storage/images/posts_intro_images/thumb_{{ $post->image }}">
            @else
                <div class="alert alert-warning" role="alert">
                    Image not found
                </div>
            @endif
            
            {!!$post->body!!}
            
        </div>
    @endforeach

</div>
