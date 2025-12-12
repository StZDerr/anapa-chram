@php
    // Если слайды не переданы напрямую, загружаем из БД
    $slides = $parkSlides ?? \App\Models\Park::active()->ordered()->limit(4)->get();
@endphp

<div class="container pb-3 pt-3">
    <div class="gallery-section">
        <div class="text-center title">КРЕЩЕНСКИЙ ПАРК</div>

        @if ($slides->isNotEmpty())
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @foreach ($slides as $index => $slide)
                        <div class="swiper-slide {{ $index === 0 ? 'active' : '' }}">
                            @if ($slide->image)
                                <img src="{{ $slide->image_url }}" alt="{{ $slide->title ?? 'Крещенский парк' }}" />
                            @else
                                <img src="{{ asset('images/ChramSvitogo.jpg') }}"
                                    alt="{{ $slide->title ?? 'Крещенский парк' }}" />
                            @endif
                            <div class="slide-overlay">
                                <!-- Заголовок с иконкой слева вверху -->
                                <div class="slide-header">
                                    @if ($slide->logo)
                                        <img src="{{ $slide->logo_url }}" alt="Логотип" class="slide-icon">
                                    @else
                                        <img src="{{ asset('images/Logo2.svg') }}" alt="Логотип" class="slide-icon">
                                    @endif
                                    <h3 class="slide-title">{{ $slide->title ?? 'Крещенский парк' }}</h3>
                                </div>
                                <!-- Описание и ссылка внизу -->
                                @if ($slide->description || $slide->link)
                                    <div class="slide-footer">
                                        @if ($slide->description)
                                            <p class="slide-description">{{ $slide->description }}</p>
                                        @endif
                                        @if ($slide->link)
                                            <a href="{{ $slide->link }}">
                                                <div class="slide-actions">
                                                    <span
                                                        class="slide-link">{{ $slide->link_text ?? 'Узнать больше' }}</span>
                                                    <svg class="slide-arrow" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2">
                                                        <line x1="5" y1="12" x2="19"
                                                            y2="12">
                                                        </line>
                                                        <polyline points="12 5 19 12 12 19"></polyline>
                                                    </svg>
                                                </div>
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-center text-muted py-5">
                Слайды не найдены
            </div>
        @endif
    </div>
</div>
