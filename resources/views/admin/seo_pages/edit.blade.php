@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>Редактировать SEO-страницу</h1>

        <form action="{{ route('admin.seo-pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="slug" class="form-label">Slug страницы</label>
                <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $page->slug) }}"
                    placeholder="например about-us">
                <div class="form-text">Оставьте пустым для главной страницы.</div>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">SEO Title</label>
                <input type="text" name="title" id="title" class="form-control"
                    value="{{ old('title', $page->title) }}">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">SEO Description</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $page->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="keywords" class="form-label">Ключевые слова (keywords)</label>
                <input type="text" name="keywords" id="keywords" class="form-control"
                    value="{{ old('keywords', $page->keywords) }}">
            </div>

            <div class="mb-3">
                <label for="h1" class="form-label">H1 заголовок</label>
                <input type="text" name="h1" id="h1" class="form-control" value="{{ old('h1', $page->h1) }}">
            </div>

            <div class="mb-3">
                <label for="canonical" class="form-label">Canonical URL</label>
                <input type="text" name="canonical" id="canonical" class="form-control"
                    value="{{ old('canonical', $page->canonical) }}">
            </div>

            <div class="mb-3">
                <label for="robots" class="form-label">Robots</label>
                <select name="robots" id="robots" class="form-select">
                    @foreach (['index, follow', 'noindex, follow', 'index, nofollow', 'noindex, nofollow'] as $r)
                        <option value="{{ $r }}" {{ old('robots', $page->robots) === $r ? 'selected' : '' }}>
                            {{ $r }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Open Graph --}}
            <div class="mb-3">
                <label for="og_title" class="form-label">OG Title</label>
                <input type="text" name="og_title" id="og_title" class="form-control"
                    value="{{ old('og_title', $page->og_title) }}">
            </div>

            <div class="mb-3">
                <label for="og_description" class="form-label">OG Description</label>
                <textarea name="og_description" id="og_description" class="form-control" rows="2">{{ old('og_description', $page->og_description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="og_image_file" class="form-label">OG Image — загрузить</label>
                <input type="file" name="og_image_file" id="og_image_file" class="form-control" accept="image/*">
                <div class="form-text">Загруженное изображение будет иметь приоритет.</div>
            </div>

            @php
                $imgUrl = $page->og_image;
                if ($imgUrl) {
                    // если относительный путь (например seo/xxx.jpg) — построим URL через storage
                    if (!\Illuminate\Support\Str::startsWith($imgUrl, ['http://', 'https://', '/'])) {
                        $imgUrl = asset('storage/' . ltrim($imgUrl, '/'));
                    }
                }
            @endphp

            @if (!empty($imgUrl))
                <div id="current_image_block" class="mb-3">
                    <label class="form-label">Текущее изображение</label>
                    <div>
                        <img id="current_image_img" src="{{ $imgUrl }}" alt=""
                            style="max-height:140px; border:1px solid #e9ecef; padding:4px;">
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image" value="1"
                            {{ old('remove_image') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remove_image">Удалить текущее изображение</label>
                    </div>
                </div>
            @endif

            <div id="og_image_preview" class="mb-3">
                <img id="og_image_preview_img" src="" alt=""
                    style="max-height:140px; display:none; border:1px solid #e9ecef; padding:4px;">
            </div>

            {{-- JSON-LD --}}
            <div class="mb-3">
                <label for="structured_data" class="form-label">Structured Data (JSON-LD)</label>
                <textarea name="structured_data" id="structured_data" class="form-control" rows="5"
                    placeholder='{"@@context": "https://schema.org"}'>
                        {{ old('structured_data', is_array($page->structured_data) ? json_encode($page->structured_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) : $page->structured_data) }}
                </textarea>
            </div>


            <div class="d-flex gap-2">
                <a href="{{ route('admin.seo-settings.index') }}" class="btn btn-secondary">Отмена</a>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            (function() {
                const fileInput = document.getElementById('og_image_file');
                const previewImg = document.getElementById('og_image_preview_img');
                const currentBlock = document.getElementById('current_image_block');

                fileInput.addEventListener('change', function() {
                    const f = this.files && this.files[0];
                    if (!f) {
                        previewImg.style.display = 'none';
                        previewImg.src = '';
                        if (currentBlock) currentBlock.style.display = 'block';
                        return;
                    }
                    // при выборе нового файла скрываем блок текущего изображения
                    if (currentBlock) currentBlock.style.display = 'none';

                    previewImg.src = URL.createObjectURL(f);
                    previewImg.style.display = 'block';
                });
            })();
        </script>
    @endpush
@endsection
