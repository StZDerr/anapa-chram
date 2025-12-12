@extends('layouts.app')

@push('styles')
    @vite(['resources/css/app.css'])
    <style>
        .image-item {
            position: relative;
            cursor: move;
        }

        .drag-handle {
            position: absolute;
            top: 8px;
            left: 8px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            z-index: 10;
            cursor: grab;
            font-size: 14px;
        }

        .drag-handle:active {
            cursor: grabbing;
        }

        .image-order-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            z-index: 10;
            font-size: 12px;
        }

        .sortable-ghost {
            opacity: 0.4;
        }
    </style>
@endpush

@section('title', 'Строительство храма')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Строительство храма</h5>
                        @if (!$construction)
                            <a href="{{ route('admin.temple-construction.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Создать запись
                            </a>
                        @endif
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (!$construction)
                            <div class="alert alert-info">
                                Запись о строительстве храма не создана.
                                <a href="{{ route('admin.temple-construction.create') }}" class="alert-link">Создать
                                    запись</a>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <h4>{{ $construction->title }}</h4>
                                    <p class="text-muted">{{ $construction->description }}</p>
                                </div>

                                @if ($construction->images->isNotEmpty())
                                    <div class="col-12 mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0">Изображения ({{ $construction->images->count() }})</h6>
                                            <small class="text-muted">
                                                <i class="fas fa-arrows-alt"></i> Перетаскивайте изображения для изменения
                                                порядка
                                            </small>
                                        </div>
                                        <div class="row g-2" id="sortableImages">
                                            @foreach ($construction->images as $image)
                                                <div class="col-6 col-md-3 col-lg-2 image-item"
                                                    data-id="{{ $image->id }}">
                                                    <div class="position-relative">
                                                        <span class="drag-handle">
                                                            <i class="fas fa-grip-vertical"></i>
                                                        </span>
                                                        <span class="image-order-badge">{{ $image->order }}</span>
                                                        <img src="{{ $image->image_url }}" class="img-thumbnail w-100"
                                                            style="height: 150px; object-fit: cover;"
                                                            alt="Изображение {{ $image->order }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <div class="col-12">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.temple-construction.edit', $construction) }}"
                                            class="btn btn-primary">
                                            <i class="fas fa-edit"></i> Редактировать
                                        </a>
                                        <form action="{{ route('admin.temple-construction.destroy', $construction) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Вы уверены? Это удалит всю информацию о строительстве и все изображения.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash"></i> Удалить запись
                                            </button>
                                        </form>
                                    </div>
                                </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            const sortable = document.getElementById('sortableImages');
            if (!sortable) return;

            new Sortable(sortable, {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'sortable-ghost',
                onEnd: function() {
                    const order = Array.from(sortable.querySelectorAll('.image-item')).map(item => item
                        .dataset.id);

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
                                sortable.querySelectorAll('.image-item').forEach((item, index) => {
                                    const badge = item.querySelector('.image-order-badge');
                                    if (badge) {
                                        badge.textContent = index;
                                    }
                                });

                                // Показываем уведомление об успехе
                                showNotification('Порядок изображений обновлен');
                            }
                        })
                        .catch(err => {
                            console.error('Ошибка:', err);
                            alert('Ошибка при обновлении порядка изображений');
                        });
                }
            });
        });

        // Функция для показа уведомлений
        function showNotification(message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-dismissible fade show position-fixed';
            alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            document.body.appendChild(alertDiv);

            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }
    </script>
@endpush
