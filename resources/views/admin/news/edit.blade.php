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

                        {{-- Ошибки валидации --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.news.update', $newsItem->id) }}" method="POST"
                            enctype="multipart/form-data" id="news-edit-form">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label">Заголовок</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" placeholder="Введите заголовок"
                                    value="{{ old('title', $newsItem->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                @include('admin.partials.editor', [
                                    'id' => 'content',
                                    'name' => 'content',
                                    'value' => old('content', $newsItem->content),
                                    'label' => 'Текст новости',
                                    'uploadUrl' => url('admin/news/upload-image'),
                                ])
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Статус</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status">
                                    <option value="published"
                                        {{ old('status', $newsItem->status) === 'published' ? 'selected' : '' }}>
                                        Опубликовано</option>
                                    <option value="draft"
                                        {{ old('status', $newsItem->status) === 'draft' ? 'selected' : '' }}>Черновик
                                    </option>
                                    <option value="pending"
                                        {{ old('status', $newsItem->status) === 'pending' ? 'selected' : '' }}>На модерации
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="published_at" class="form-label">Дата публикации</label>
                                <input type="date" class="form-control @error('published_at') is-invalid @enderror"
                                    id="published_at" name="published_at"
                                    value="{{ old('published_at', $newsItem->published_at ? \Illuminate\Support\Carbon::parse($newsItem->published_at)->format('Y-m-d') : '') }}">
                                @error('published_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="img_preview" class="form-label">Фотография Превью</label>
                                <input type="file" class="form-control @error('img_preview') is-invalid @enderror"
                                    id="img_preview" name="img_preview" accept="image/*">
                                <small class="text-muted">Можно выбрать только один файл</small>
                                @error('img_preview')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if ($newsItem->img_preview)
                                    <div class="mt-2" style="max-width: 300px;">
                                        <img src="{{ Storage::disk('public')->exists($newsItem->img_preview) ? Storage::url($newsItem->img_preview) : asset('images/placeholder.png') }}"
                                            alt="Превью новости" class="img-thumbnail w-100"
                                            style="object-fit: cover; height: 180px;">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                id="remove_preview" name="remove_preview">
                                            <label class="form-check-label" for="remove_preview">Удалить старое
                                                превью</label>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="images" class="form-label">Фотографии новости</label>
                                <input type="file" class="form-control @error('images.*') is-invalid @enderror"
                                    id="images" name="images[]" multiple accept="image/*">
                                <small class="text-muted">Можно выбрать несколько файлов</small>
                                @error('images.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if ($newsItem->images && $newsItem->images->count())
                                    <div class="mt-2 d-flex flex-wrap gap-3" id="news-images-list"
                                        style="--img-thumb-width: 23%;">
                                        @foreach ($newsItem->images as $image)
                                            <div class="position-relative news-image-thumb"
                                                data-image-id="{{ $image->id }}"
                                                style="width: var(--img-thumb-width); min-width: 180px; max-width: 260px;">
                                                <img src="{{ Storage::disk('public')->exists($image->path) ? Storage::url($image->path) : asset('images/placeholder.png') }}"
                                                    alt="Фото новости" class="img-thumbnail w-100"
                                                    style="object-fit:cover; height:150px;">
                                                <button type="button"
                                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 news-image-remove-btn"
                                                    style="z-index:2; border-radius:50%; padding:0.2rem 0.45rem; font-size:1rem; line-height:1;">&times;</button>
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
@endsection
