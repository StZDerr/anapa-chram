<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.seo')
    @include('partials.head')

    <!-- Стили страницы Treby -->
    @vite(['resources/css/treby-show.css', 'resources/js/treby-show.js', 'resources/css/calendar-swiper.css', 'resources/js/calendar-swiper.js'])
</head>

<body class="d-flex flex-column min-vh-100">
    @include('partials.navbar')

    <main class="flex-fill">
        <div class="treby-show">
            <div class="container py-5">
                <h1 class="text-center treby-title mb-5">{{ $block->title }}</h1>
                @if ($block->title_desc)
                    <div class="title-desc mb-3">{{ $block->title_desc }}</div>
                @endif
                <div class="row">
                    <div class="col-12 col-lg-6 d-flex">
                        @if ($block->images && $block->images->isNotEmpty())
                            <div class="swiper-container-wrapper"
                                style="width:100%; align-self:flex-start; position:sticky; top:100px; z-index:2;">
                                <!-- Большое изображение -->
                                <div class="swiper treby-gallery-top">
                                    <div class="swiper-wrapper">
                                        @foreach ($block->images as $image)
                                            <div class="swiper-slide">
                                                <img src="{{ $image->image_url }}" alt="{{ $block->title }}">
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Навигация -->
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>

                                <!-- Превью (миниатюры) -->
                                <div class="swiper treby-gallery-thumbs">
                                    <div class="swiper-wrapper">
                                        @foreach ($block->images as $image)
                                            <div class="swiper-slide">
                                                <img src="{{ $image->image_url }}" alt="{{ $block->title }} - превью">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info w-100">
                                <i class="fas fa-info-circle"></i> Изображения пока не загружены.
                            </div>
                        @endif
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="construction-info">

                            <div class="construction-text">
                                {!! $block->desc !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-2 mt-3">
                    <div class="row">
                        <div class="col-6">
                            <h2 class="block-2-title">{{ $block->block_2_title }}</h2>
                            <div class="block-2-desc">{!! $block->block_2_desc !!}</div>
                        </div>
                        <div class="col-6">
                            <img src="{{ asset('storage/' . $block->block_2_img) }}" alt="{{ $block->title }}"
                                class="img-fluid" loading="lazy">
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @include('partials.calendar-partials')
    </main>

    @include('partials.footer')


</body>

</html>
