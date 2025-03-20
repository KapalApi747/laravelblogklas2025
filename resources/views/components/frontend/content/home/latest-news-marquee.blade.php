<div class="latest-news-marquee-area">
    <div class="simple-marquee-container">
        <div class="marquee">
            <ul class="marquee-content-items">
                @foreach ($brNews as $item)
                    <li>
                        <a target="_blank" href="{{ $item['url'] }}"><span class="latest-news-time">{{ $item['publishedAt'] ?? 'Onbekend' }}</span> {{ $item['title'] }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
