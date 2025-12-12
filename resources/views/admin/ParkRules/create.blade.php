@extends('layouts.app')

@push('styles')
    @vite(['resources/css/app.css'])
@endpush

@section('title', 'Создать правила парка')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Создать правила парка</h5>
                        <a href="{{ route('admin.park-rules.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Назад
                        </a>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.park-rules.store') }}" method="POST">
                            @csrf

                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary border-bottom pb-2">Блок "Правила посещения"</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="allowed_title">
                                        Заголовок <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="allowed_title" name="allowed_title"
                                        value="{{ old('allowed_title', 'Правила посещения') }}"
                                        class="form-control @error('allowed_title') is-invalid @enderror" required>
                                    @error('allowed_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="allowed_subtitle">Подзаголовок</label>
                                    <input type="text" id="allowed_subtitle" name="allowed_subtitle"
                                        value="{{ old('allowed_subtitle', 'на территории парка крещения руси') }}"
                                        class="form-control @error('allowed_subtitle') is-invalid @enderror"
                                        placeholder="на территории парка крещения руси">
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
                                        value="{{ old('prohibited_title', 'Запрещается') }}"
                                        class="form-control @error('prohibited_title') is-invalid @enderror" required>
                                    @error('prohibited_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="prohibited_subtitle">Подзаголовок</label>
                                    <input type="text" id="prohibited_subtitle" name="prohibited_subtitle"
                                        value="{{ old('prohibited_subtitle', 'на территории парка крещения руси') }}"
                                        class="form-control @error('prohibited_subtitle') is-invalid @enderror"
                                        placeholder="на территории парка крещения руси">
                                    @error('prohibited_subtitle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-save"></i> Создать запись
                                </button>
                                <a href="{{ route('admin.park-rules.index') }}" class="btn btn-secondary">
                                    Отмена
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
