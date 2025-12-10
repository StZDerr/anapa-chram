@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('components.alerts')

            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Редактировать фото</h5>
                        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary btn-sm">К списку фото</a>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.gallery.update', $photo->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Заголовок</label>
                                <input type="text" name="title" value="{{ old('title', $photo->title) }}"
                                    class="form-control @error('title') is-invalid @enderror">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Категория</label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror"
                                    required>
                                    <option value="">— выберите —</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ old('category_id', $photo->category_id) == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Текущее изображение</label>
                                <div class="mb-2">
                                    @if ($photo->file_path)
                                        <img src="{{ asset('storage/' . $photo->file_path) }}" alt=""
                                            style="max-height:150px;">
                                    @else
                                        <div class="text-muted">Нет изображения</div>
                                    @endif
                                </div>

                                <label class="form-label">Заменить изображение (опционально)</label>
                                <input type="file" name="image" accept="image/*"
                                    class="form-control @error('image') is-invalid @enderror">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <div>
                                    <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Отмена</a>
                                    <button type="submit" class="btn btn-primary">Сохранить</button>
                                </div>
                            </div>
                        </form>
                        <form action="{{ route('admin.gallery.destroy', $photo->id) }}" method="POST"
                            onsubmit="return confirm('Удалить фото?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger">Удалить</button>
                        </form>
                    </div> <!-- card-body -->
                </div> <!-- card -->
            </div> <!-- col-12 -->
        </div> <!-- row -->
    </div> <!-- container-fluid -->
@endsection
