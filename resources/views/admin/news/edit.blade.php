@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Редактировать новость</h5>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary btn-sm">Назад к списку</a>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.news.update', $newsItem->id) }}"
                            enctype="multipart/form-data" id="news-edit-form">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="title" class="form-label">Заголовок</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ old('title', $newsItem->title) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Текст новости</label>
                                <textarea class="form-control" id="content" name="content" rows="6" required>{{ old('content', $newsItem->content) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Статус</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="published" @if (old('status', $newsItem->status) === 'published') selected @endif>
                                        Опубликовано</option>
                                    <option value="draft" @if (old('status', $newsItem->status) === 'draft') selected @endif>
                                        Черновик</option>
                                    <option value="pending" @if (old('status', $newsItem->status) === 'pending') selected @endif>
                                        На модерации</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="published_at" class="form-label">Дата публикации</label>
                                <input type="date" class="form-control" id="published_at" name="published_at"
                                    value="{{ old('published_at', $newsItem->published_at ? \Illuminate\Support\Carbon::parse($newsItem->published_at)->format('Y-m-d') : '') }}">
                            </div>
                            <div class="mb-3">
                                <label for="images" class="form-label">Изображения</label>
                                <input type="file" class="form-control" id="images" name="images[]" multiple>
                                @if ($newsItem->images && count($newsItem->images))
                                    <div class="mt-2 d-flex flex-wrap gap-3" id="news-images-list"
                                        style="--img-thumb-width: 23%;">
                                        @foreach ($newsItem->images as $image)
                                            <div class="position-relative news-image-thumb"
                                                data-image-id="{{ $image->id }}"
                                                style="width: var(--img-thumb-width); min-width: 180px; max-width: 260px;">
                                                <img src="{{ asset('storage/' . $image->path) }}" alt="Фото новости"
                                                    class="img-thumbnail w-100" style="object-fit:cover; height:150px;">
                                                <button type="button"
                                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 news-image-remove-btn"
                                                    style="z-index:2; border-radius:50%; padding:0.2rem 0.45rem; font-size:1rem; line-height:1;">
                                                    &times;
                                                </button>
                                                <input type="hidden" name="remove_images[]" value="" disabled>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const imagesList = document.getElementById('news-images-list');
                if (!imagesList) return;
                imagesList.querySelectorAll('.news-image-remove-btn').forEach(function(btn) {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const thumb = btn.closest('.news-image-thumb');
                        thumb.classList.toggle('opacity-50');
                        const input = thumb.querySelector('input[name="remove_images[]"]');
                        if (thumb.classList.contains('opacity-50')) {
                            input.value = thumb.dataset.imageId;
                            input.disabled = false;
                        } else {
                            input.value = '';
                            input.disabled = true;
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
