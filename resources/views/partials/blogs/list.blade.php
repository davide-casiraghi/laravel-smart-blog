{{-- eg. https://www.saveur.com/tags/blog-awards --}}

<div class="row">
    
@foreach ($posts as $key => $post)
    <div class="col-3">
        @if(!empty($post->image))
            <img class="ml-sm-3 float-sm-right img-fluid" alt="{{ $post->title }}" src="/storage/images/events_teaser/thumb_{{ $post->image }}">
        @else
            <div class="alert alert-danger" role="alert">
                Image not found
            </div>
        @endif
    </div>
    <div class="col-7">
        
        <h4>{{ $post->title }}</h4>
            
        {!! $post->body !!}
            
        {{ $post->created_by }}
            
        
    </div>
    
    
    
@endforeach

</div>
