@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('components.alerts')

            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Добавить фото</h5>
                        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary btn-sm">К списку фото</a>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Заголовок</label>
                                <input type="text" name="title" value="{{ old('title') }}"
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
                                            {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Файл изображения</label>
                                <input type="file" name="image" accept="image/*"
                                    class="form-control @error('image') is-invalid @enderror" required>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Макс. размер по настройкам сервера.</small>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Отмена</a>
                                <button type="submit" class="btn btn-primary">Загрузить</button>
                            </div>
                        </form>
                    </div> <!-- card-body -->
                </div> <!-- card -->
            </div> <!-- col-12 -->
        </div> <!-- row -->
    </div> <!-- container-fluid -->
@endsection
