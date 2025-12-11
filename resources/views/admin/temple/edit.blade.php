@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('components.alerts')

            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        @if ($page->page_key == 'kupel-olgi')
                            <h5 class="mb-0">Редактирование страницы Купели Ольги</h5>
                        @elseif ($page->page_key == 'temple_main')
                            <h5 class="mb-0">Редактирование страницы Храма</h5>
                        @else
                            <h5 class="mb-0">Редактирование страницы Державной иконы Божией Матери</h5>
                        @endif

                        <a href="{{ route('temple') }}" class="btn btn-secondary btn-sm" target="_blank">Просмотр страницы</a>
                    </div>

                    <div class="card-body">
                        @if ($page->page_key == 'kupel-olgi')
                            <form action="{{ route('admin.temple.kupelOlgi.update') }}" method="POST"
                                enctype="multipart/form-data">
                            @elseif ($page->page_key == 'temple_main')
                                <form action="{{ route('admin.temple.update') }}" method="POST"
                                    enctype="multipart/form-data">
                                @else
                                    <form action="{{ route('admin.temple.derzhavnayaIkona.update') }}" method="POST"
                                        enctype="multipart/form-data">
                        @endif
                        @csrf

                        <div class="mb-4">
                            <h6 class="mb-2">Основная информация</h6>

                            <div class="mb-3">
                                <label for="title" class="form-label">Заголовок страницы</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title"
                                    value="{{ old('title', $page->title ?? 'Храм святого равноапостольного великого князя Владимира') }}">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="about_text" class="form-label">Текст "О храме"</label>
                                <textarea class="form-control @error('about_text') is-invalid @enderror" id="about_text" name="about_text"
                                    rows="6">{{ old('about_text', $page->about_text ?? '') }}</textarea>
                                @error('about_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Можно использовать HTML-разметку</small>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-4">
                            <h6 class="mb-2">Галерея 1 (верхняя)</h6>

                            @if (!empty($page->gallery_1_images))
                                <div class="mb-3">
                                    <label class="form-label">Текущие изображения:</label>
                                    <div class="row g-2">
                                        @foreach ($page->gallery_1_images as $index => $image)
                                            <div class="col-md-3 col-6">
                                                <div class="card">
                                                    <img src="{{ asset('storage/' . $image) }}" class="card-img-top"
                                                        alt="Gallery 1">
                                                    <div class="card-body p-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="remove_gallery_1[]" value="{{ $image }}"
                                                                id="remove_g1_{{ $index }}">
                                                            <label class="form-check-label"
                                                                for="remove_g1_{{ $index }}">
                                                                Удалить
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="gallery_1_images" class="form-label">Добавить изображения</label>
                                <input type="file" class="form-control @error('gallery_1_images.*') is-invalid @enderror"
                                    id="gallery_1_images" name="gallery_1_images[]" multiple accept="image/*">
                                @error('gallery_1_images.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Можно выбрать несколько файлов. Макс. 5MB каждый</small>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-4">
                            <h6 class="mb-2">Информация об открытии</h6>

                            <div class="mb-3">
                                <label for="opening_title" class="form-label">Заголовок раздела</label>
                                <input type="text" class="form-control @error('opening_title') is-invalid @enderror"
                                    id="opening_title" name="opening_title"
                                    value="{{ old('opening_title', $page->opening_title ?? 'Открытие храма') }}">
                                @error('opening_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="opening_text" class="form-label">Краткий текст</label>
                                <textarea class="form-control @error('opening_text') is-invalid @enderror" id="opening_text" name="opening_text"
                                    rows="3">{{ old('opening_text', $page->opening_text ?? '') }}</textarea>
                                @error('opening_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="opening_details" class="form-label">Подробный текст</label>
                                <textarea class="form-control @error('opening_details') is-invalid @enderror" id="opening_details"
                                    name="opening_details" rows="4">{{ old('opening_details', $page->opening_details ?? '') }}</textarea>
                                @error('opening_details')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Можно использовать HTML-разметку</small>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-4">
                            <h6 class="mb-2">Галерея 2 (нижняя)</h6>

                            @if (!empty($page->gallery_2_images))
                                <div class="mb-3">
                                    <label class="form-label">Текущие изображения:</label>
                                    <div class="row g-2">
                                        @foreach ($page->gallery_2_images as $index => $image)
                                            <div class="col-md-3 col-6">
                                                <div class="card">
                                                    <img src="{{ asset('storage/' . $image) }}" class="card-img-top"
                                                        alt="Gallery 2">
                                                    <div class="card-body p-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="remove_gallery_2[]" value="{{ $image }}"
                                                                id="remove_g2_{{ $index }}">
                                                            <label class="form-check-label"
                                                                for="remove_g2_{{ $index }}">
                                                                Удалить
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="gallery_2_images" class="form-label">Добавить изображения</label>
                                <input type="file"
                                    class="form-control @error('gallery_2_images.*') is-invalid @enderror"
                                    id="gallery_2_images" name="gallery_2_images[]" multiple accept="image/*">
                                @error('gallery_2_images.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Можно выбрать несколько файлов. Макс. 5MB каждый</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Назад к админке</a>
                            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                        </div>
                        </form>
                    </div> <!-- card-body -->
                </div> <!-- card -->
            </div> <!-- col-12 -->
        </div> <!-- row -->
    </div> <!-- container-fluid -->
@endsection
