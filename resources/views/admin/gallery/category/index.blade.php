@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('components.alerts')

            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Категории фотографий</h5>
                        <div>
                            <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary btn-sm">К списку фото</a>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="collapse"
                                data-bs-target="#createCategoryForm" aria-expanded="false">
                                Добавить категорию
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="collapse mb-3" id="createCategoryForm">
                            <form action="{{ route('admin.gallery.categories.store') }}" method="POST">
                                @csrf
                                <div class="row g-2 align-items-end">
                                    <div class="col-md-12">
                                        <label class="form-label">Название</label>
                                        <input name="name" value="{{ old('name') }}"
                                            class="form-control @error('name') is-invalid @enderror" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2 d-grid">
                                        <button class="btn btn-success">Создать</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Название</th>
                                        <th>Фото</th>
                                        <th>Создано</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($categories as $category)
                                        <tr>
                                            <td>{{ $category->id }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ $category->photos_count ?? $category->photos()->count() }}
                                                </span>
                                            </td>
                                            <td>{{ optional($category->created_at)->format('Y-m-d') }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                                    data-bs-toggle="modal" data-bs-target="#editCategoryModal"
                                                    data-id="{{ $category->id }}" data-name="{{ $category->name }}"
                                                    data-update-url="{{ route('admin.gallery.categories.update', $category->id) }}">
                                                    Редактировать
                                                </button>

                                                <form
                                                    action="{{ route('admin.gallery.categories.destroy', $category->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Удалить категорию?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger">Удалить</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Нет категорий</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            @if (method_exists($categories, 'links'))
                                {{ $categories->links() }}
                            @endif
                        </div>
                    </div> <!-- card-body -->
                </div> <!-- card -->
            </div> <!-- col-12 -->
        </div> <!-- row -->
    </div> <!-- container-fluid -->

    <!-- Edit modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editCategoryForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Редактировать категорию</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Название</label>
                            <input type="text" name="name" id="editCategoryName" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отменить</button>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editModal = document.getElementById('editCategoryModal');
            if (!editModal) return;

            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name') || '';
                const updateUrl = button.getAttribute('data-update-url');

                const form = document.getElementById('editCategoryForm');
                const inputName = document.getElementById('editCategoryName');

                if (form && updateUrl) {
                    form.setAttribute('action', updateUrl);
                }
                if (inputName) inputName.value = name;
            });
        });
    </script>
@endpush
