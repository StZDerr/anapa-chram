@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('components.alerts')

            <div class="col-md-9 offset-md-3"> {{-- Если есть sidebar --}}
                <div class="card mb-4">
                    <div class="card-header">
                        Редактировать категорию
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.gallery.categories.update', $photoCategory->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Название</label>
                                <input type="text" name="name" value="{{ old('name', $photoCategory->name) }}"
                                    class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
