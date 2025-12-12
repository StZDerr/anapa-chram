@extends('layouts.app')

@push('styles')
    @vite(['resources/css/app.css'])
    <style>
        .rule-item {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            background: #fff;
        }

        .rule-item .svg-preview {
            max-width: 60px;
            max-height: 60px;
        }
    </style>
@endpush

@section('title', 'Редактировать правила парка')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Редактировать правила парка</h5>
                        <a href="{{ route('admin.park-rules.index') }}" class="btn btn-secondary">
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

                        {{-- Форма редактирования заголовков --}}
                        <form action="{{ route('admin.park-rules.update', $parkRule) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary border-bottom pb-2">Блок "Правила посещения"</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="allowed_title">
                                        Заголовок <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="allowed_title" name="allowed_title"
                                        value="{{ old('allowed_title', $parkRule->allowed_title) }}"
                                        class="form-control @error('allowed_title') is-invalid @enderror" required>
                                    @error('allowed_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="allowed_subtitle">Подзаголовок</label>
                                    <input type="text" id="allowed_subtitle" name="allowed_subtitle"
                                        value="{{ old('allowed_subtitle', $parkRule->allowed_subtitle) }}"
                                        class="form-control @error('allowed_subtitle') is-invalid @enderror">
                                    @error('allowed_subtitle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-danger border-bottom pb-2">Блок "Запрещается"</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="prohibited_title">
                                        Заголовок <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="prohibited_title" name="prohibited_title"
                                        value="{{ old('prohibited_title', $parkRule->prohibited_title) }}"
                                        class="form-control @error('prohibited_title') is-invalid @enderror" required>
                                    @error('prohibited_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="prohibited_subtitle">Подзаголовок</label>
                                    <input type="text" id="prohibited_subtitle" name="prohibited_subtitle"
                                        value="{{ old('prohibited_subtitle', $parkRule->prohibited_subtitle) }}"
                                        class="form-control @error('prohibited_subtitle') is-invalid @enderror">
                                    @error('prohibited_subtitle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex gap-2 mb-4">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-save"></i> Сохранить заголовки
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">

                        {{-- Управление пунктами правил --}}
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-check-circle"></i> Правила посещения ({{ $parkRule->allowed_items->count() }})
                        </h6>

                        @foreach ($parkRule->allowed_items as $index => $item)
                            <div class="rule-item">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex gap-3 flex-grow-1">
                                        @if (!empty($item['svg']))
                                            <img src="{{ $parkRule->getSvgUrl($item['svg']) }}" class="svg-preview"
                                                alt="Иконка">
                                        @else
                                            <div
                                                class="svg-preview d-flex align-items-center justify-content-center bg-light rounded">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <p class="mb-0">{{ $item['title'] }}</p>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-danger"
                                        onclick="deleteItem('{{ $parkRule->id }}', '{{ $item['id'] ?? $index }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach

                        {{-- Форма добавления нового правила --}}
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h6 class="mb-3">Добавить новое правило</h6>
                                <form action="{{ route('admin.park-rules.add-item', $parkRule) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="category" value="allowed">
                                    <div class="row">
                                        <div class="col-md-8 mb-3">
                                            <label class="form-label">Текст правила <span
                                                    class="text-danger">*</span></label>
                                            <textarea name="title" class="form-control" rows="2" required></textarea>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">SVG иконка</label>
                                            <input type="file" name="svg" class="form-control"
                                                accept=".svg,image/svg+xml,image/png,image/jpeg">
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-plus"></i> Добавить
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Управление запретами --}}
                        <h6 class="text-danger mb-3">
                            <i class="fas fa-ban"></i> Запрещается ({{ $parkRule->prohibited_items->count() }})
                        </h6>

                        @foreach ($parkRule->prohibited_items as $index => $item)
                            <div class="rule-item">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex gap-3 flex-grow-1">
                                        @if (!empty($item['svg']))
                                            <img src="{{ $parkRule->getSvgUrl($item['svg']) }}" class="svg-preview"
                                                alt="Иконка">
                                        @else
                                            <div
                                                class="svg-preview d-flex align-items-center justify-content-center bg-light rounded">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <p class="mb-0">{{ $item['title'] }}</p>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-danger"
                                        onclick="deleteItem('{{ $parkRule->id }}', '{{ $item['id'] ?? $index }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach

                        {{-- Форма добавления нового запрета --}}
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="mb-3">Добавить новый запрет</h6>
                                <form action="{{ route('admin.park-rules.add-item', $parkRule) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="category" value="prohibited">
                                    <div class="row">
                                        <div class="col-md-8 mb-3">
                                            <label class="form-label">Текст запрета <span
                                                    class="text-danger">*</span></label>
                                            <textarea name="title" class="form-control" rows="2" required></textarea>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">SVG иконка</label>
                                            <input type="file" name="svg" class="form-control"
                                                accept=".svg,image/svg+xml,image/png,image/jpeg">
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-plus"></i> Добавить
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function deleteItem(parkRuleId, itemId) {
            if (!confirm('Удалить этот пункт?')) {
                return;
            }

            fetch(`/admin/park-rules/${parkRuleId}/delete-item/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(err => {
                    console.error('Ошибка:', err);
                    alert('Ошибка при удалении пункта');
                });
        }
    </script>
@endpush
