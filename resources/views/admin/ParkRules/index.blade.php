@extends('layouts.app')

@push('styles')
    @vite(['resources/css/app.css'])
@endpush

@section('title', 'Правила парка')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Правила парка</h5>
                        @if (!$parkRule)
                            <a href="{{ route('admin.park-rules.create') }}" class="btn btn-primary">
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

                        @if (!$parkRule)
                            <div class="alert alert-info">
                                Правила парка не созданы.
                                <a href="{{ route('admin.park-rules.create') }}" class="alert-link">Создать запись</a>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-primary">Блок "Правила посещения"</h6>
                                    <p class="mb-1"><strong>Заголовок:</strong> {{ $parkRule->allowed_title }}</p>
                                    <p class="mb-0"><strong>Подзаголовок:</strong>
                                        {{ $parkRule->allowed_subtitle ?? '—' }}</p>
                                    <p class="mt-2 mb-0"><strong>Количество пунктов:</strong>
                                        {{ $parkRule->allowed_items->count() }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <h6 class="text-danger">Блок "Запрещается"</h6>
                                    <p class="mb-1"><strong>Заголовок:</strong> {{ $parkRule->prohibited_title }}</p>
                                    <p class="mb-0"><strong>Подзаголовок:</strong>
                                        {{ $parkRule->prohibited_subtitle ?? '—' }}</p>
                                    <p class="mt-2 mb-0"><strong>Количество пунктов:</strong>
                                        {{ $parkRule->prohibited_items->count() }}</p>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.park-rules.edit', $parkRule) }}" class="btn btn-primary">
                                            <i class="fas fa-edit"></i> Редактировать
                                        </a>
                                        <form action="{{ route('admin.park-rules.destroy', $parkRule) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Вы уверены? Это удалит всю информацию о правилах.');">
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
