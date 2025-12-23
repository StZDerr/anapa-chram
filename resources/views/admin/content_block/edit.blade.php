@extends('layouts.app')

@push('styles')
    @vite(['resources/css/content-blocks.css'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endpush

@section('content')
    <div class="container content-blocks">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h4 mb-0">Редактировать контент-блок</h1>
            <a href="{{ route('admin.content-blocks.index') }}" class="btn btn-secondary">Отмена</a>
        </div>

        <form action="{{ route('admin.content-blocks.update', $contentBlock) }}" method="POST" enctype="multipart/form-data"
            id="contentBlockForm">
            @csrf
            @method('PUT')

            <div class="mb-3 text-center">
                <label for="title" class="form-label">Заголовок <span class="text-danger">*</span></label>
                <input id="title" name="title" type="text"
                    class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title', $contentBlock->title) }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 text-center">
                <label for="title_desc" class="form-label">Краткое описание заголовка</label>
                <input id="title_desc" name="title_desc" type="text"
                    class="form-control @error('title_desc') is-invalid @enderror"
                    value="{{ old('title_desc', $contentBlock->title_desc) }}">
                @error('title_desc')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row align-items-start gap-4">
                <!-- LEFT: existing gallery + uploader -->
                <div class="col-lg-6">
                    <label class="form-label">Фотогалерея</label>

                    <div class="swiper create-gallery-top" id="createGalleryTop">
                        <div class="swiper-wrapper">
                            {{-- existing slides will be seeded by JS from blade var --}}
                        </div>
                        <div class="swiper-button-prev create-prev" aria-label="Предыдущий"></div>
                        <div class="swiper-button-next create-next" aria-label="Следующий"></div>
                    </div>

                    <div class="swiper create-gallery-thumbs mt-3" id="createGalleryThumbs">
                        <div class="swiper-wrapper"></div>
                    </div>

                    <div class="mt-3">
                        <label for="images" class="form-label">Загрузить изображения галереи (много)</label>
                        <input type="file" id="images" name="images[]" multiple accept="image/*"
                            class="form-control @error('images.*') is-invalid @enderror">
                        @error('images.*')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Рекомендуемый формат: WebP, jpg, png. Макс 2MB</small>
                    </div>

                    <hr>

                    <div>
                        <div class="mb-2"><strong>Существующие изображения</strong></div>
                        <div id="existingImagesContainer" class="row g-3">
                            @foreach ($contentBlock->images as $img)
                                <div class="col-6 col-md-4 image-item" data-id="{{ $img->id }}">
                                    <div class="position-relative">
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 end-0 delete-existing-image"
                                            data-id="{{ $img->id }}" title="Удалить">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <img src="{{ Storage::url($img->img) }}" class="img-thumbnail w-100"
                                            style="height:120px; object-fit:cover;" alt="">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <small class="text-muted">Перетаскивайте, чтобы изменить порядок.</small>
                        <div class="mt-2">
                            <button type="button" id="saveOrderBtn" class="btn btn-sm btn-outline-primary">Сохранить
                                порядок</button>
                        </div>
                    </div>
                </div>

                <!-- RIGHT: Description editor -->
                <div class="col-lg-6">
                    @include('admin.partials.editor', [
                        'id' => 'desc',
                        'name' => 'desc',
                        'value' => old('desc', $contentBlock->desc),
                        'label' => 'Описание (справа)',
                    ])
                </div>
            </div>

            <!-- Block 2 -->
            <div class="row align-items-center mt-4">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="block_2_title" class="form-label">Block 2 — Заголовок</label>
                        <input id="block_2_title" name="block_2_title" type="text"
                            class="form-control @error('block_2_title') is-invalid @enderror"
                            value="{{ old('block_2_title', $contentBlock->block_2_title) }}">
                        @error('block_2_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @include('admin.partials.editor', [
                        'id' => 'block_2_desc',
                        'name' => 'block_2_desc',
                        'value' => old('block_2_desc', $contentBlock->block_2_desc),
                        'label' => 'Block 2 — Текст',
                    ])
                </div>

                <div class="col-lg-6 text-center">
                    <label for="block_2_img" class="form-label">Block 2 — Картинка (право)</label>
                    @if ($contentBlock->block_2_img && Storage::disk('public')->exists($contentBlock->block_2_img))
                        <div class="mb-2">
                            <img src="{{ Storage::url($contentBlock->block_2_img) }}" class="img-fluid block-2-img"
                                alt="">
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="remove_block_2_img"
                                id="remove_block_2_img" value="1">
                            <label class="form-check-label" for="remove_block_2_img">Удалить текущее изображение</label>
                        </div>
                    @endif
                    <input id="block_2_img" name="block_2_img" type="file" accept="image/*"
                        class="form-control mb-3 @error('block_2_img') is-invalid @enderror">
                    @error('block_2_img')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div id="block2Preview" class="block2-preview"></div>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Сохранить</button>
                <a href="{{ route('admin.content-blocks.index') }}" class="btn btn-secondary">Отмена</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Seed existing images array
            let existingImages = @json($contentBlock->images->map(fn($i) => ['id' => $i->id, 'url' => Storage::url($i->img)]));
            const topWrapper = document.querySelector('#createGalleryTop .swiper-wrapper');
            const thumbsWrapper = document.querySelector('#createGalleryThumbs .swiper-wrapper');

            function renderAllSlides() {
                topWrapper.innerHTML = '';
                thumbsWrapper.innerHTML = '';
                existingImages.forEach(img => {
                    const slide = document.createElement('div');
                    slide.className = 'swiper-slide';
                    slide.innerHTML =
                        `<a href="${img.url}"><img src="${img.url}" style="width:100%;height:100%;object-fit:cover;"></a>`;
                    topWrapper.appendChild(slide);

                    const thumb = document.createElement('div');
                    thumb.className = 'swiper-slide';
                    thumb.innerHTML =
                        `<img src="${img.url}" style="width:100%;height:100%;object-fit:cover;">`;
                    thumbsWrapper.appendChild(thumb);
                });

                if (window.createThumbs) {
                    window.createThumbs.update();
                } else {
                    initSwipers(); // initial
                }
            }

            // Initialize swipers
            let topSwiper, thumbsSwiper;

            function initSwipers() {
                if (thumbsSwiper) thumbsSwiper.destroy(true, true);
                if (topSwiper) topSwiper.destroy(true, true);

                thumbsSwiper = new Swiper('#createGalleryThumbs', {
                    spaceBetween: 8,
                    slidesPerView: Math.min(4, document.querySelectorAll(
                        '#createGalleryThumbs .swiper-slide').length),
                    watchSlidesProgress: true,
                });

                topSwiper = new Swiper('#createGalleryTop', {
                    spaceBetween: 10,
                    navigation: {
                        nextEl: '.create-next',
                        prevEl: '.create-prev'
                    },
                    thumbs: {
                        swiper: thumbsSwiper
                    },
                });

                // expose for re-init
                window.createThumbs = topSwiper;
            }

            renderAllSlides();

            document.getElementById('images').addEventListener('change', function(e) {
                const files = e.target.files;
                Array.from(files).forEach(file => {
                    const url = URL.createObjectURL(file);
                    // push as temporary
                    existingImages.push({
                        id: null,
                        url: url,
                        temp: true,
                        fileName: file.name
                    });
                });
                renderAllSlides();
            });

            // Deleting existing image via AJAX
            document.querySelectorAll('.delete-existing-image').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (!confirm('Удалить изображение?')) return;
                    const id = this.dataset.id;
                    fetch(`/admin/content-blocks/images/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    }).then(r => r.json()).then(res => {
                        if (res.success) {
                            existingImages = existingImages.filter(i => i.id != id);
                            renderAllSlides();
                            this.closest('.image-item').remove();
                        } else {
                            alert('Ошибка при удалении.');
                        }
                    });
                });
            });

            // Save order (uses ContentBlockController@updateOrder)
            const sortable = new Sortable(document.getElementById('existingImagesContainer'), {
                handle: '.image-item',
                animation: 150,
                onEnd: function() {
                    // nothing automatic — user must click save
                }
            });

            document.getElementById('saveOrderBtn').addEventListener('click', function() {
                const order = Array.from(document.querySelectorAll('#existingImagesContainer .image-item'))
                    .map(el => el.dataset.id);
                fetch('{{ route('admin.content-blocks.update-order') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        order
                    })
                }).then(r => r.json()).then(j => {
                    if (j.success) alert('Порядок сохранён');
                });
            });

            // block2 preview replace
            document.getElementById('block_2_img').addEventListener('change', function(e) {
                const preview = document.getElementById('block2Preview');
                preview.innerHTML = '';
                const f = e.target.files[0];
                if (!f) return;
                const url = URL.createObjectURL(f);
                const img = document.createElement('img');
                img.src = url;
                img.className = 'img-fluid';
                img.style.borderRadius = '12px';
                preview.appendChild(img);
            });
        });
    </script>
@endpush
