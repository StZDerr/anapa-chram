@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('components.alerts')
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Фотогалерея</h5>
                        <div>
                            <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary btn-sm">Добавить фото</a>
                            <a href="{{ route('admin.gallery.categories.index') }}"
                                class="btn btn-secondary btn-sm">Управление категориями</a>
                        </div>
                    </div>

                    <!-- Фильтр по категориям -->
                    <div class="card-body pb-0">
                        <form method="GET" action="{{ route('admin.gallery.index') }}" class="mb-3">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-4">
                                    <label for="category_filter" class="form-label">Фильтр по категории:</label>
                                    <select name="category_id" id="category_filter" class="form-select">
                                        <option value="">Все категории</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }} ({{ $category->photos_count }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary">Применить</button>
                                    <a href="{{ route('admin.gallery.index') }}"
                                        class="btn btn-outline-secondary">Сбросить</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Превью</th>
                                        <th scope="col">Название</th>
                                        <th scope="col">Категория</th>
                                        <th scope="col">Дата добавления</th>
                                        <th scope="col">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($photos as $photo)
                                        <tr>
                                            <th scope="row">{{ $photo->id }}</th>
                                            <td>
                                                <img src="{{ asset('storage/' . $photo->file_path) }}"
                                                    alt="{{ $photo->title }}" class="img-thumbnail"
                                                    style="max-width: 80px; max-height: 80px; object-fit: cover;">
                                            </td>
                                            <td>{{ $photo->title ?: 'Без названия' }}</td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ $photo->category->name ?? 'Без категории' }}
                                                </span>
                                            </td>
                                            <td>{{ $photo->created_at->format('d.m.Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('admin.gallery.edit', $photo->id) }}"
                                                    class="btn btn-sm btn-outline-secondary">Редактировать</a>
                                                <form action="{{ route('admin.gallery.destroy', $photo->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Удалить фото?')">Удалить</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <p class="text-muted mb-0">Фотографии не найдены</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($photos->hasPages())
                        <div class="card-footer">
                            {{ $photos->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
