@extends('layouts.app')

@push('styles')
    @vite(['resources/css/app.css', 'resources/css/park.css'])
@endpush

@section('title', 'Добавить достопримечательность')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5>Добавить достопримечательность</h5>
                <a href="{{ route('admin.attractions.index') }}" class="btn btn-secondary btn-sm float-end">Назад</a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.attractions.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Название</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Описание</label>
                        <textarea name="description" id="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Изображение</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="order" class="form-label">Порядок</label>
                        <input type="number" name="order" id="order" class="form-control"
                            value="{{ old('order', 0) }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </form>
            </div>
        </div>
    </div>
@endsection
