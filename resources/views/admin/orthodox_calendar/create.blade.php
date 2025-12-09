@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('components.alerts')
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Добавить запись календаря</h5>
                        <a href="{{ route('admin.orthodox_calendar.index') }}"
                            class="btn btn-sm btn-outline-secondary">Назад</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.orthodox_calendar.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="date" class="form-label">Дата</label>
                                <input type="date" name="date" id="date" class="form-control"
                                    value="{{ old('date') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Заголовок</label>
                                <input type="text" name="title" id="title" class="form-control"
                                    value="{{ old('title') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Описание</label>
                                <textarea name="description" id="description" class="form-control" rows="6">{{ old('description') }}</textarea>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary" type="submit">Сохранить</button>
                                <a href="{{ route('admin.orthodox_calendar.index') }}"
                                    class="btn btn-outline-secondary">Отмена</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
