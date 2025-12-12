@extends('layouts.app')

@section('title', 'Редактировать достопримечательность')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Редактировать: {{ $attraction->title ?? 'Без названия' }}</h5>
                <a href="{{ route('admin.attractions.index') }}" class="btn btn-secondary btn-sm">Назад</a>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.attractions.update', $attraction) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="title" class="form-label">Название</label>
                        <input type="text" name="title" id="title" class="form-control"
                            value="{{ old('title', $attraction->title) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Описание</label>
                        <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $attraction->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Загрузить изображение</label>
                        <input type="file" name="image" id="image" class="form-control">
                        <div class="form-text">Поддерживаются изображения. Новая загрузка заменит старое.</div>
                    </div>

                    @php
                        $img = $attraction->image;
                        if ($img) {
                            if (Str::startsWith($img, ['http://', 'https://'])) {
                                $src = $img;
                            } elseif (Str::startsWith($img, ['/'])) {
                                $src = $img;
                            } else {
                                $src = '/storage/' . ltrim($img, '/');
                            }
                        } else {
                            $src = null;
                        }
                    @endphp

                    @if (!empty($src))
                        <div class="mb-3">
                            <label class="form-label">Текущее изображение</label>
                            <div>
                                <img src="{{ $src }}" alt="{{ $attraction->title }}"
                                    style="max-height:140px; border:1px solid #e9ecef; padding:4px;">
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image"
                                    value="1">
                                <label class="form-check-label" for="remove_image">Удалить текущее изображение</label>
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="order" class="form-label">Порядок</label>
                        <input type="number" name="order" id="order" class="form-control"
                            value="{{ old('order', $attraction->order) }}">
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.attractions.index') }}" class="btn btn-secondary">Отмена</a>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
