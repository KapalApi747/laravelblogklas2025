<section class="single-post-area">
    <!-- Single Post Title -->
    <div class="single-post-title bg-img background-overlay" style="background-image: url({{asset('assets/img/'.$post->photo->path)}});">
        <div class="container h-100">
            <div class="row h-100 align-items-end">
                <div class="col-12">
                    <div class="single-post-title-content">
                        <!-- Post Tag -->
                        <div class="gazette-post-tag">
                            @foreach($post->categories as $category)
                                <a href="#">{{$category->name}}</a>
                            @endforeach

                        </div>
                        <h2 class="font-pt">{{$post->title}}</h2>
                        <p>{{$post->created_at}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="single-post-contents">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8">
                    <div class="single-post-text">
                        <p>{{$post->content}}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
