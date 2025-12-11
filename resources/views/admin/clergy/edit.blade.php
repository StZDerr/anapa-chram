@extends('layouts.app')

@section('content')
    <main class="flex-fill">
        <div class="container">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Редактировать священнослужителя</h5>
                    <a href="{{ route('admin.clergy.index') }}" class="btn btn-secondary btn-sm">Назад</a>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.clergy.update', $clergy->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="full_name" class="form-label">ФИО</label>
                            <input type="text" name="full_name" id="full_name" class="form-control"
                                value="{{ old('full_name', $clergy->full_name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="position" class="form-label">Должность</label>
                            <input type="text" name="position" id="position" class="form-control"
                                value="{{ old('position', $clergy->position) }}">
                        </div>

                        <div class="mb-3">
                            <label for="order" class="form-label">Порядок (число)</label>
                            <input type="number" name="order" id="order" class="form-control"
                                value="{{ old('order', $clergy->order) }}">
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Категория</label>
                            <select name="category" id="category" class="form-select" required>
                                <option value="ДУХОВЕНСТВО ХРАМА"
                                    {{ old('category', $clergy->category) === 'ДУХОВЕНСТВО ХРАМА' ? 'selected' : '' }}>
                                    ДУХОВЕНСТВО ХРАМА
                                </option>
                                <option value="ПЕРСОНАЛ ХРАМА"
                                    {{ old('category', $clergy->category) === 'ПЕРСОНАЛ ХРАМА' ? 'selected' : '' }}>
                                    ПЕРСОНАЛ ХРАМА
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Текущее фото</label>
                            <div>
                                @if ($clergy->image)
                                    <img src="{{ asset('storage/' . $clergy->image) }}" alt=""
                                        style="height:120px; object-fit:cover; border-radius:6px;">
                                @else
                                    <div class="text-muted">Фото не загружено</div>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="hidden" name="remove_image" value="0">
                            <input type="checkbox" name="remove_image" id="remove_image" class="form-check-input"
                                value="1">
                            <label for="remove_image" class="form-check-label">Удалить текущее фото</label>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Загрузить новое фото (jpeg, png, webp)</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                            <a href="{{ route('admin.clergy.index') }}" class="btn btn-outline-secondary">Отмена</a>
                        </div>
                    </form>

                    <hr class="my-4">

                    <form action="{{ route('admin.clergy.destroy', $clergy->id) }}" method="post"
                        onsubmit="return confirm('Удалить запись?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Удалить запись</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
