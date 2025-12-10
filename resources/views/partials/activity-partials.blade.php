<div class="container">
    <div class="activity mt-3">
        <div class="text-center title">ДЕЯТЕЛЬНОСТЬ ХРАМА</div>
        <div class="activity-swiper-container">
            <div class="swiper">
                <div class="swiper-wrapper">
                    @forelse ($activitys as $activity)
                        <div class="swiper-slide">
                            <a href="{{ route('activity.read', $activity->slug) }}">
                                <div class="activity-slide-inner">
                                    <img src="{{ $activity->img_preview ? asset('storage/' . $activity->img_preview) : asset('images/newsOne.jpg') }}"
                                        alt="{{ $activity->title }}" class="activity-slide-img">
                                    <div class="activity-slide-overlay">
                                        <div class="activity-slide-title">{{ $activity->title }}</div>
                                        <div class="activity-slide-desc">
                                            {{ Str::limit(strip_tags($activity->content), 132) }}</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="null">Новостей про деятельность пока нет</div>
                    @endforelse

                </div>

                <!-- Pagination (точки) -->
                <div class="swiper-pagination activity-pagination"></div>
            </div>
        </div>
    </div>
</div>
