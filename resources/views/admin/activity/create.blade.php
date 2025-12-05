@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Добавить активность</h5>
                        <a href="{{ route('admin.activity.index') }}" class="btn btn-outline-secondary btn-sm">Назад к
                            списку</a>
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

                        <form action="{{ route('admin.activity.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Заголовок</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" placeholder="Введите заголовок"
                                    value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Текст новости</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="6"
                                    placeholder="Введите текст новости..." required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Статус</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status">
                                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>
                                        Опубликовано</option>
                                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Черновик
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="published_at" class="form-label">Дата публикации</label>
                                <input type="date" class="form-control" id="published_at" name="published_at"
                                    value="{{ old('published_at') }}">
                                @error('published_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="img_preview" class="form-label">Фотография Превью</label>
                                <input type="file" class="form-control @error('img_preview') is-invalid @enderror"
                                    id="img_preview" name="img_preview" accept="image/*" required>
                                <small class="text-muted">Можно выбрать только один файл!</small>
                                @error('img_preview')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="images" class="form-label">Фотографии новости</label>
                                <input type="file" class="form-control @error('images.*') is-invalid @enderror"
                                    id="images" name="images[]" multiple accept="image/*">
                                <small class="text-muted">Можно выбрать несколько файлов</small>
                                @error('images.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Сохранить</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
