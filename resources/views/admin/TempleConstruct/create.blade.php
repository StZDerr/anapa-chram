@extends('layouts.app')

@push('styles')
    @vite(['resources/css/app.css'])
@endpush

@section('title', 'Создать запись — Строительство храма')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Создать запись о строительстве</h5>
                        <a href="{{ route('admin.temple-construction.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Назад
                        </a>
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

                        <form action="{{ route('admin.temple-construction.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="title">Заголовок <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="title" name="title" value="{{ old('title') }}"
                                    class="form-control @error('title') is-invalid @enderror" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="description">Описание</label>
                                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                                    rows="8">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="images">Загрузить изображения (можно несколько)</label>
                                <input type="file" id="images" name="images[]"
                                    class="form-control @error('images.*') is-invalid @enderror"
                                    accept="image/webp,image/jpeg,image/png,image/jpg" multiple>
                                <small class="text-muted">Рекомендуемый формат: WebP. Максимальный размер: 2MB</small>
                                @error('images.*')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-save"></i> Создать запись
                                </button>
                                <a href="{{ route('admin.temple-construction.index') }}" class="btn btn-secondary">
                                    Отмена
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
