@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Просмотр новости</h5>
                        <div>
                            <a href="{{ route('admin.activity.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                Редактировать
                            </a>
                            <a href="{{ route('admin.activity.index') }}" class="btn btn-outline-secondary btn-sm">
                                Назад к списку
                            </a>
                        </div>
                    </div>
                    <div class="card-body">

                        {{-- Заголовок --}}
                        <div class="mb-4">
                            <h3>{{ $item->title }}</h3>
                            <div class="text-muted">
                                <small>
                                    <strong>Slug:</strong> {{ $item->slug }}
                                </small>
                            </div>
                        </div>

                        {{-- Статус и дата публикации --}}
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p><strong>Статус:</strong>
                                    @if ($item->status === 'published')
                                        <span class="badge bg-success">Опубликовано</span>
                                    @elseif($item->status === 'draft')
                                        <span class="badge bg-secondary">Черновик</span>
                                    @else
                                        <span class="badge bg-warning">{{ $item->status }}</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Дата публикации:</strong>
                                    {{ $item->published_at ? $item->published_at->format('d.m.Y') : 'Не указана' }}
                                </p>
                            </div>
                        </div>

                        {{-- Превью изображение --}}
                        @if ($item->img_preview)
                            <div class="mb-4">
                                <h5>Превью изображения</h5>
                                @if (Storage::disk('public')->exists($item->img_preview))
                                    <img src="{{ Storage::url($item->img_preview) }}" alt="Preview"
                                        class="img-fluid rounded shadow-sm" style="max-height: 400px; object-fit: cover;">
                                @else
                                    <div class="alert alert-warning">
                                        Файл превью не найден: {{ $item->img_preview }}
                                    </div>
                                @endif
                            </div>
                        @endif

                        {{-- Контент новости --}}
                        <div class="mb-4">
                            <h5>Содержание</h5>
                            <div class="border rounded p-3 bg-light">
                                {!! $item->content !!}
                            </div>
                        </div>

                        {{-- Галерея изображений --}}
                        @if ($item->images && $item->images->count() > 0)
                            <div class="mb-4">
                                <h5>Галерея изображений ({{ $item->images->count() }})</h5>
                                <div class="row g-3">
                                    @foreach ($item->images as $image)
                                        <div class="col-md-3">
                                            @if (Storage::disk('public')->exists($image->path))
                                                <img src="{{ Storage::url($image->path) }}" alt="Gallery Image"
                                                    class="img-fluid rounded shadow-sm"
                                                    style="width: 100%; height: 200px; object-fit: cover;">
                                            @else
                                                <div class="alert alert-warning mb-0 p-2 text-center"
                                                    style="height: 200px; display: flex; align-items: center; justify-content: center;">
                                                    <small>Файл не найден</small>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Даты создания/обновления --}}
                        <div class="border-top pt-3 mt-4">
                            <div class="row text-muted">
                                <div class="col-md-6">
                                    <small><strong>Создано:</strong>
                                        {{ $item->created_at->format('d.m.Y H:i') }}</small>
                                </div>
                                <div class="col-md-6">
                                    <small><strong>Обновлено:</strong>
                                        {{ $item->updated_at->format('d.m.Y H:i') }}</small>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Стили для контента с CKEditor */
        .bg-light {
            background-color: #f8f9fa !important;
        }

        /* Стили для изображений в контенте */
        .bg-light img {
            max-width: 100%;
            height: auto;
        }

        .bg-light figure.image {
            margin: 1rem 0;
        }

        .bg-light figure.image img {
            border-radius: 0.25rem;
        }

        /* Выравнивание изображений CKEditor */
        .bg-light .image-style-align-left,
        .bg-light .image-style-side {
            float: left;
            margin: 0 1.5em 1em 0;
            max-width: 50%;
        }

        .bg-light .image-style-align-right {
            float: right;
            margin: 0 0 1em 1.5em;
            max-width: 50%;
        }

        .bg-light .image-style-align-center {
            display: block;
            margin: 1em auto;
            text-align: center;
        }

        .bg-light .image-inline {
            display: inline-block;
            max-width: 100%;
        }

        /* Очистка float для корректного отображения */
        .bg-light::after,
        .bg-light p::after {
            content: "";
            display: table;
            clear: both;
        }

        /* Стили для ссылок в контенте */
        .bg-light a {
            color: #0d6efd;
            text-decoration: underline;
        }

        .bg-light a:hover {
            color: #0a58ca;
        }
    </style>
@endpush
