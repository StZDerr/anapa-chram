@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>Создать SEO-страницу</h1>

        <form action="{{ route('admin.seo-pages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Основные поля --}}
            <div class="mb-3">
                <label for="slug" class="form-label">Slug страницы</label>
                <input type="text" name="slug" id="slug" class="form-control" placeholder="например about-us">
                <div class="form-text">Оставьте пустым для главной страницы.</div>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">SEO Title</label>
                <input type="text" name="title" id="title" class="form-control">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">SEO Description</label>
                <textarea name="description" id="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="keywords" class="form-label">Ключевые слова (keywords)</label>
                <input type="text" name="keywords" id="keywords" class="form-control">
            </div>

            <div class="mb-3">
                <label for="h1" class="form-label">H1 заголовок</label>
                <input type="text" name="h1" id="h1" class="form-control">
            </div>

            {{-- Продвинутое SEO --}}
            <div class="mb-3">
                <label for="canonical" class="form-label">Canonical URL</label>
                <input type="text" name="canonical" id="canonical" class="form-control">
            </div>

            <div class="mb-3">
                <label for="robots" class="form-label">Robots</label>
                <select name="robots" id="robots" class="form-select">
                    <option value="index, follow">index, follow</option>
                    <option value="noindex, follow">noindex, follow</option>
                    <option value="index, nofollow">index, nofollow</option>
                    <option value="noindex, nofollow">noindex, nofollow</option>
                </select>
            </div>

            {{-- Open Graph --}}
            <div class="mb-3">
                <label for="og_title" class="form-label">OG Title</label>
                <input type="text" name="og_title" id="og_title" class="form-control">
            </div>

            <div class="mb-3">
                <label for="og_description" class="form-label">OG Description</label>
                <textarea name="og_description" id="og_description" class="form-control" rows="2"></textarea>
            </div>

            <div class="mb-3">
                <label for="og_image_file" class="form-label">OG Image — загрузить</label>
                <input type="file" name="og_image_file" id="og_image_file" class="form-control" accept="image/*">
                <div class="form-text">Загруженное изображение будет использовано для Open Graph.</div>
            </div>

            <div id="og_image_preview" class="mb-3">
                <img id="og_image_preview_img" src="" alt=""
                    style="max-height:140px; display:none; border:1px solid #e9ecef; padding:4px;">
            </div>

            {{-- JSON-LD --}}
            <div class="mb-3">
                <label for="structured_data" class="form-label">Structured Data (JSON-LD)</label>
                <textarea name="structured_data" id="structured_data" class="form-control" rows="5"
                    placeholder='{"@@context": "https://schema.org"}'></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Создать страницу</button>
        </form>
    </div>

    @push('scripts')
        <script>
            (function() {
                const fileInput = document.getElementById('og_image_file');
                const previewImg = document.getElementById('og_image_preview_img');

                fileInput.addEventListener('change', function() {
                    const f = this.files && this.files[0];
                    if (!f) {
                        previewImg.style.display = 'none';
                        previewImg.src = '';
                        return;
                    }
                    previewImg.src = URL.createObjectURL(f);
                    previewImg.style.display = 'block';
                });
            })();
        </script>
    @endpush
@endsection
