@extends('layouts.app')

@section('title', 'Достопримечательности')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Управление достопримечательностями</h5>
                        <a href="{{ route('admin.attractions.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Добавить достопримечательность
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

                        @if ($attractions->isEmpty())
                            <div class="alert alert-info">
                                Достопримечательности не найдены.
                                <a href="{{ route('admin.attractions.create') }}">Создать первую</a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover" id="attractionsTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px;">
                                                <i class="fas fa-sort" title="Перетащите для сортировки"></i>
                                            </th>
                                            <th style="width: 80px;">Превью</th>
                                            <th>Название</th>
                                            <th>Описание</th>
                                            <th style="width: 80px;">Порядок</th>
                                            <th style="width: 150px;">Действия</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sortableAttractions">
                                        @foreach ($attractions as $attraction)
                                            <tr data-id="{{ $attraction->id }}" draggable="true">
                                                <td class="drag-handle" style="cursor: grab;">
                                                    <i class="fas fa-grip-vertical"></i>
                                                </td>
                                                <td>
                                                    @if ($attraction->image)
                                                        <img src="/storage/{{ $attraction->image }}"
                                                            alt="{{ $attraction->title }}" class="img-thumbnail"
                                                            style="max-height:50px; max-width:80px; object-fit:cover;">
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <strong>{{ $attraction->title ?? 'Без названия' }}</strong>
                                                </td>
                                                <td>
                                                    @if ($attraction->description)
                                                        <small
                                                            class="text-muted">{{ Str::limit($attraction->description, 50) }}</small>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $attraction->order }}</td>
                                                <td>
                                                    <a href="{{ route('admin.attractions.edit', $attraction) }}"
                                                        class="btn btn-sm btn-outline-primary" title="Редактировать">
                                                        <i class="fas fa-edit"></i> Редактировать
                                                    </a>
                                                    <form action="{{ route('admin.attractions.destroy', $attraction) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Удалить эту достопримечательность?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            title="Удалить">
                                                            <i class="fas fa-trash"></i> Удалить
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
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sortable = document.getElementById('sortableAttractions');
            if (sortable) {
                new Sortable(sortable, {
                    handle: '.drag-handle',
                    animation: 150,
                    onEnd: function(evt) {
                        const order = Array.from(sortable.querySelectorAll('tr')).map(row => row.dataset
                            .id);

                        fetch('{{ route('admin.attractions.update-order') }}', {
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
                                    // Успешно
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    }
                });
            }
        });
    </script>
@endpush
