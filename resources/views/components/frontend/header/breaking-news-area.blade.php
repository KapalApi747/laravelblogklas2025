<div class="col-12 col-md-6">
    <div class="breaking-news-area">
        <h5 class="breaking-news-title">Breaking news</h5>
        <div id="breakingNewsTicker" class="ticker">
            <ul>
               @foreach($breakingNews as $news)
                   <li>
                       <a href="#">{{$news->title}}</a>
                   </li>
               @endforeach
            </ul>
        </div>
    </div>
</div>
