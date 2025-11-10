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
                $imageUrl = $post->image 
                    ? asset('storage/' . $post->image) 
                    : 'https://source.unsplash.com/1200x400/?' . urlencode($post->category->name);
            @endphp

            <div style="max-height: 400px; overflow: hidden;">
                <img src="{{ $imageUrl }}" 
                     alt="Image for category {{ $post->category->name }}" 
                     class="img-fluid w-100" 
                     style="height:400px; object-fit:cover; margin-top: 1rem;">
            </div>

            <!-- Konten Post -->
            <article class="my-3 fs-5">
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
