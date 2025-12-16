@extends('layouts.app')

@push('styles')
    @vite(['resources/css/park.css', 'resources/js/park.js', 'resources/css/park-swiper.css', 'resources/css/app.css'])
@endpush

@section('title', 'Слайды парка')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Управление слайдами парка</h5>
                        <a href="{{ route('admin.park.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Добавить слайд
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

                        @if ($slides->isEmpty())
                            <div class="alert alert-info">
                                Слайды не найдены. <a href="{{ route('admin.park.create') }}">Создать первый слайд</a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover" id="slidesTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px;">
                                                <i class="fas fa-sort" title="Перетащите для сортировки"></i>
                                            </th>
                                            <th style="width: 80px;">Превью</th>
                                            <th>Заголовок</th>
                                            <th>Ссылка</th>
                                            <th style="width: 80px;">Порядок</th>
                                            <th style="width: 80px;">Статус</th>
                                            <th style="width: 150px;">Действия</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sortableSlides">
                                        @foreach ($slides as $slide)
                                            <tr data-id="{{ $slide->id }}">
                                                <td class="drag-handle" style="cursor: grab;">
                                                    <i class="fas fa-grip-vertical"></i>
                                                </td>
                                                <td>
                                                    @if ($slide->image)
                                                        <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}"
                                                            class="img-thumbnail"
                                                            style="max-height: 50px; max-width: 80px; object-fit: cover;">
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <strong>{{ $slide->title ?? 'Без заголовка' }}</strong>
                                                    @if ($slide->description)
                                                        <br><small
                                                            class="text-muted">{{ Str::limit(strip_tags($slide->description), 100) }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($slide->link)
                                                        <a href="{{ $slide->link }}" target="_blank" class="text-primary">
                                                            {{ $slide->link_text ?? 'Узнать больше' }}
                                                        </a>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $slide->order }}</td>
                                                <td class="text-center">
                                                    @if ($slide->is_active)
                                                        <span class="badge bg-success">Активен</span>
                                                    @else
                                                        <span class="badge bg-secondary">Скрыт</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.park.edit', $slide) }}"
                                                        class="btn btn-sm btn-outline-primary" title="Редактировать">
                                                        <i class="fas fa-edit"></i>
                                                        Редактировать
                                                    </a>
                                                    <form action="{{ route('admin.park.destroy', $slide) }}" method="POST"
                                                        class="d-inline" onsubmit="return confirm('Удалить этот слайд?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            title="Удалить">
                                                            <i class="fas fa-trash"></i>
                                                            УДалить
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Превью слайдера -->
                @if ($slides->where('is_active', true)->isNotEmpty())
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0">Превью слайдера (только активные)</h5>
                        </div>
                        <div class="card-body p-0" style="background: #f5f5f5;">
                            @include('partials.park-partials', [
                                'parkSlides' => $slides->where('is_active', true),
                            ])
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sortable = document.getElementById('sortableSlides');
            if (sortable) {
                new Sortable(sortable, {
                    handle: '.drag-handle',
                    animation: 150,
                    onEnd: function(evt) {
                        const order = Array.from(sortable.querySelectorAll('tr')).map(row => row.dataset
                            .id);

                        fetch('{{ route('admin.park.update-order') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    order: order
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Можно показать уведомление об успехе
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    }
                });
            }
        });
    </script>
@endpush
