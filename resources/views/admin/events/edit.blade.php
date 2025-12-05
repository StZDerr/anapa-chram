@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Редактировать событие</h5>
                        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary btn-sm">Назад к
                            календарю</a>
                    </div>
                    <div class="card-body">

                        {{-- Ошибки валидации --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.events.update', $event->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label">Название события</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title', $event->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Описание</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="4">{{ old('description', $event->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="start" class="form-label">Дата и время начала</label>
                                <input type="datetime-local" class="form-control @error('start') is-invalid @enderror"
                                    id="start" name="start"
                                    value="{{ old('start', $event->start ? \Carbon\Carbon::parse($event->start)->format('Y-m-d\TH:i') : '') }}"
                                    required>
                                @error('start')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="end" class="form-label">Дата и время окончания</label>
                                <input type="datetime-local" class="form-control @error('end') is-invalid @enderror"
                                    id="end" name="end"
                                    value="{{ old('end', $event->end ? \Carbon\Carbon::parse($event->end)->format('Y-m-d\TH:i') : '') }}">
                                @error('end')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="color" class="form-label">Цвет события</label>
                                <input type="color"
                                    class="form-control form-control-color @error('color') is-invalid @enderror"
                                    id="color" name="color" value="{{ old('color', $event->color ?? '#378006') }}">
                                @error('color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <button type="submit" class="btn btn-primary">Обновить событие</button>
                            </div>
                        </form>
                        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST"
                            onsubmit="return confirm('Вы уверены, что хотите удалить это событие?');" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Удалить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
