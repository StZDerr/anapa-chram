<div class="container pb-3 pt-3">
    <div class="news">
        <div class="text-center title">
            НОВОСТИ И СОБЫТИЯ
        </div>
        <!-- Обертка для свайпера с кнопками -->
        <div class="swiper-wrapper-outer">
            <div class="swiper-button-prev news-button-prev">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </div>
            <div class="swiper-button-next news-button-next">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </div>
            <!-- Slider main container -->
            <div class="swiper-container">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    @forelse ($news as $newsItem)
                        <div class="swiper-slide">
                            <div class="slide-inner">
                                <img src="{{ $newsItem->img_preview ? asset('storage/' . $newsItem->img_preview) : asset('images/newsOne.jpg') }}"
                                    alt="{{ $newsItem->title }}" class="slide-img">
                                <div class="slide-title">{{ Str::limit(strip_tags($newsItem->title), 20) }}</div>
                                <div class="slide-desc">
                                    {{ Str::limit(strip_tags($newsItem->content), 100) }}
                                </div>
                                <div class="slide-read">
                                    <a href="{{ route('news.read', $newsItem->slug) }}">
                                        Читать
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="null">Новостей пока нет</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
