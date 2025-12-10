<div class="container mb-5">
    <div class="photo-section">

        <div class="text-center title">ФОТОГАЛЕРЕЯ</div>

        <!-- Фильтры категорий -->
        <div class="photo-filters d-flex justify-content-center gap-3 mb-5">
            @foreach ($categories as $i => $category)
                <button class="btn btn-filter {{ $i === 0 ? 'active' : '' }}" data-target="#gallery-{{ $category->id }}">
                    {{ $category->name }}
                    <span class="badge bg-secondary ms-1">{{ $category->photos->count() }}</span>
                </button>
            @endforeach
        </div>

        <!-- Галереи: по одному Swiper на категорию -->
        <div class="gallery-wrap">
            @foreach ($categories as $i => $category)
                <div id="gallery-{{ $category->id }}" class="gallery-instance {{ $i === 0 ? '' : 'd-none' }}">
                    <!-- Кнопки навигации для {{ $category->name }} -->
                    <div class="swiper-button-prev gallery-{{ Str::slug($category->name) }}-prev">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                    </div>
                    <div class="swiper-button-next gallery-{{ Str::slug($category->name) }}-next">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </div>

                    <div class="swiper gallery-swiper gallery-{{ Str::slug($category->name) }}-swiper">
                        <div class="swiper-wrapper">
                            @forelse ($category->photos as $photo)
                                @php
                                    $storagePath = storage_path('app/public/' . $photo->file_path);
                                    $imgSize = @getimagesize($storagePath);
                                    $imgW = $imgSize[0] ?? 1200;
                                    $imgH = $imgSize[1] ?? 800;
                                @endphp
                                <div class="swiper-slide">
                                    <a href="{{ asset('storage/' . $photo->file_path) }}"
                                        data-pswp-width="{{ $imgW }}" data-pswp-height="{{ $imgH }}">
                                        <img src="{{ asset('storage/' . $photo->file_path) }}"
                                            alt="{{ $photo->title ?? $category->name }}">
                                    </a>
                                </div>
                            @empty
                                <div class="swiper-slide">
                                    <div class="text-center text-muted py-4">В этой категории пока нет фотографий.</div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
