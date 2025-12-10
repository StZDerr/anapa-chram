@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Создание категории</h1>

        @include('components.alerts')

        <form action="{{ route('admin.gallery.categories.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Название</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Slug (опционально)</label>
                <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                    value="{{ old('slug') }}">
                @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Создать категорию</button>
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Назад к списку</a>
        </form>
    </div>
@endsection
