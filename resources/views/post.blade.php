@extends('layouts.main')

@section('container')
<div class="container">
    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <!-- Judul Post -->
            <h2 class="mb-3">{{ $post->title }}</h2>

            <!-- Author & Category -->
            <p>
                By <a href="{{ route('posts.index', ['author' => $post->author->username]) }}"
                      class="text-decoration-none">{{ $post->author->name }}</a>
                in <a href="{{ route('posts.index', ['category' => $post->category->slug]) }}"
                      class="text-decoration-none">{{ $post->category->name }}</a>
            </p>

            <!-- Gambar Post -->
             @php
    use Illuminate\Support\Str;

    if ($post->image) {
       
        if (Str::startsWith($post->image, 'http')) {
            $imageUrl = $post->image;
        } else {
           
            $imageUrl = asset('storage/' . $post->image);
        }
    } else {
        
        $imageUrl = "https://picsum.photos/1200/400?random=" . rand(1, 9999);
    }
@endphp

<div class="post-hero aspect-banner mb-3">
    <img src="{{ $imageUrl }}" alt="Image for {{ $post->title }}" class="img-fluid">
</div>



           

            <!-- Konten Post -->
            <article class="my-3 fs-5" style="line-height: 1.75; font-size:1.05rem;">
                {!! $post->body !!}
            </article>

            <a href="{{ route('posts.index') }}" class="d-block mt-4 text-decoration-none">Back to Posts</a>
        </div>
    </div>

    <!-- Disqus Comments -->
    <div id="disqus_thread"></div>
    <script>
        var disqus_config = function () {
            this.page.url = "{{ url()->current() }}";
            this.page.identifier = "post-{{ $post->id }}";
        };
        (function() {
            var d = document, s = d.createElement('script');
            s.src = 'https://zonadien-com.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>
        Please enable JavaScript to view the 
        <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a>
    </noscript>
</div>
@endsection
