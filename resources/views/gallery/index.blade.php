<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>Фотогалерея - Храм святого князя Владимира в Анапе</title>
    @include('partials.head')

    <!-- PhotoSwipe v5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/photoswipe@5/dist/photoswipe.css" />

    <!-- Стили страницы Gallery -->
    @vite(['resources/css/gallery.css', 'resources/js/gallery.js'])
</head>

<body class="d-flex flex-column min-vh-100">
    @include('partials.navbar')

    <main class="flex-fill">
        <div class="container py-5">
            <div class="photo-section">
                <h1 class="text-center title mb-4">ФОТОГАЛЕРЕЯ</h1>

                <!-- Фильтры категорий -->
                <div class="photo-filters d-flex justify-content-center gap-3 mb-5">
                    <button class="btn btn-filter active" data-target="#gallery-all">Все
                        <span class="badge bg-secondary ms-1">{{ $allPhotos->count() }}</span>
                    </button>

                    @foreach ($categories as $i => $category)
                        <button class="btn btn-filter" data-target="#gallery-{{ $category->id }}">
                            {{ $category->name }}
                            <span class="badge bg-secondary ms-1">{{ $category->photos->count() }}</span>
                        </button>
                    @endforeach
                </div>

                <!-- Галереи: сетка изображений -->
                <div class="gallery-wrap">
                    {{-- Панель "Все" (открыта по умолчанию) --}}
                    <div id="gallery-all" class="gallery-instance">
                        <div class="gallery-grid">
                            @foreach ($allPhotos as $photo)
                                @php
                                    $storagePath = storage_path('app/public/' . $photo->file_path);
                                    $imgSize = @getimagesize($storagePath);
                                    $imgW = $imgSize[0] ?? 1200;
                                    $imgH = $imgSize[1] ?? 800;
                                @endphp

                                <a href="{{ asset('storage/' . $photo->file_path) }}" class="gallery-item"
                                    data-pswp-width="{{ $imgW }}" data-pswp-height="{{ $imgH }}"
                                    data-cropped="true" target="_blank" rel="noopener">
                                    <img src="{{ asset('storage/' . $photo->file_path) }}"
                                        alt="{{ $photo->title ?? '' }}">
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- По категориям: каждая категория своя панель (по умолчанию скрыта) --}}
                    @foreach ($categories as $category)
                        <div id="gallery-{{ $category->id }}" class="gallery-instance d-none">
                            <div class="gallery-grid">
                                @forelse ($category->photos as $photo)
                                    @php
                                        $storagePath = storage_path('app/public/' . $photo->file_path);
                                        $imgSize = @getimagesize($storagePath);
                                        $imgW = $imgSize[0] ?? 1200;
                                        $imgH = $imgSize[1] ?? 800;
                                    @endphp

                                    <a href="{{ asset('storage/' . $photo->file_path) }}" class="gallery-item"
                                        data-pswp-width="{{ $imgW }}" data-pswp-height="{{ $imgH }}"
                                        data-cropped="true" target="_blank" rel="noopener">
                                        <img src="{{ asset('storage/' . $photo->file_path) }}"
                                            alt="{{ $photo->title ?? '' }}">
                                    </a>
                                @empty
                                    <div class="text-center text-muted py-4">В этой категории пока нет фотографий.</div>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')

    @include('partials.scripts')

    <!-- PhotoSwipe v5 JS (Core + Lightbox) -->
    <script src="https://cdn.jsdelivr.net/npm/photoswipe@5/dist/umd/photoswipe.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/photoswipe@5/dist/umd/photoswipe-lightbox.umd.min.js"></script>
</body>

</html>
