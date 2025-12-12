@extends('layouts.app')

@push('styles')
    @vite(['resources/css/app.css'])
    <style>
        .image-item {
            position: relative;
            cursor: move;
        }

        .image-item .delete-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            z-index: 10;
        }

        .drag-handle {
            cursor: grab;
            position: absolute;
            top: 5px;
            left: 5px;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            padding: 5px 8px;
            border-radius: 4px;
            z-index: 10;
        }
    </style>
@endpush

@section('title', 'Редактировать — Строительство храма')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Редактировать запись о строительстве</h5>
                        <a href="{{ route('admin.temple-construction.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Назад
                        </a>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.temple-construction.update', $templeConstruction) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label" for="title">Заголовок <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="title" name="title"
                                    value="{{ old('title', $templeConstruction->title) }}"
                                    class="form-control @error('title') is-invalid @enderror" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="description">Описание</label>
                                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                                    rows="8">{{ old('description', $templeConstruction->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="images">Добавить новые изображения</label>
                                <input type="file" id="images" name="images[]"
                                    class="form-control @error('images.*') is-invalid @enderror"
                                    accept="image/webp,image/jpeg,image/png,image/jpg" multiple>
                                <small class="text-muted">Рекомендуемый формат: WebP. Максимальный размер: 2MB</small>
                                @error('images.*')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2 mb-4">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-save"></i> Сохранить изменения
                                </button>
                                <a href="{{ route('admin.temple-construction.index') }}" class="btn btn-secondary">
                                    Отмена
                                </a>
                            </div>
                        </form>

                        @if ($templeConstruction->images->isNotEmpty())
                            <hr class="my-4">
                            <h6 class="mb-3">Управление изображениями ({{ $templeConstruction->images->count() }})</h6>
                            <p class="text-muted small">Перетаскивайте изображения для изменения порядка</p>

                            <div class="row g-3" id="sortableImages">
                                @foreach ($templeConstruction->images as $image)
                                    <div class="col-6 col-md-4 col-lg-3 image-item" data-id="{{ $image->id }}">
                                        <div class="position-relative">
                                            <span class="drag-handle">
                                                <i class="fas fa-grip-vertical"></i>
                                            </span>
                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                onclick="deleteImage({{ $image->id }}, this)"
                                                title="Удалить изображение">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <img src="{{ $image->image_url }}" class="img-thumbnail w-100"
                                                style="height: 200px; object-fit: cover;"
                                                alt="Изображение {{ $image->order }}">
                                            <div class="text-center small text-muted mt-1">Порядок: {{ $image->order }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        // Инициализация сортировки изображений
        document.addEventListener('DOMContentLoaded', function() {
            const sortable = document.getElementById('sortableImages');
            if (sortable) {
                new Sortable(sortable, {
                    handle: '.drag-handle',
                    animation: 150,
                    onEnd: function() {
                        const order = Array.from(sortable.querySelectorAll('.image-item')).map(item =>
                            item.dataset.id);

                        fetch('{{ route('admin.temple-construction.update-order') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    order
                                })
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    // Обновляем номера порядка на странице
                                    sortable.querySelectorAll('.image-item').forEach((item,
                                        index) => {
                                            const orderText = item.querySelector('.text-muted');
                                            if (orderText) {
                                                orderText.textContent = 'Порядок: ' + index;
                                            }
                                        });
                                }
                            })
                            .catch(err => console.error('Ошибка:', err));
                    }
                });
            }
        });

        // Удаление изображения
        function deleteImage(imageId, button) {
            if (!confirm('Удалить это изображение?')) {
                return;
            }

            fetch(`/admin/temple-construction/images/${imageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Удаляем элемент из DOM
                        button.closest('.image-item').remove();

                        // Показываем уведомление
                        alert('Изображение удалено');
                    }
                })
                .catch(err => {
                    console.error('Ошибка:', err);
                    alert('Ошибка при удалении изображения');
                });
        }
    </script>
@endpush
