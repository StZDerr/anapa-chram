@extends('layouts.app')

@section('content')
    @vite(['resources/css/photo-section.css'])
    <main class="flex-fill">
        <div class="container">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Священнослужители</h5>
                    <a href="{{ route('admin.clergy.create') }}" class="btn btn-primary btn-sm">Добавить священнослужителя</a>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Фото</th>
                                    <th scope="col">ФИО</th>
                                    <th scope="col">Должность</th>
                                    <th scope="col">Порядок</th>
                                    <th scope="col">Категория</th>
                                    <th scope="col">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clergy as $item)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            @if ($item->image)
                                                <img src="{{ asset('storage/' . $item->image) }}"
                                                    alt="{{ $item->full_name }}"
                                                    style="height:48px; width:auto; object-fit:cover; border-radius:4px;">
                                            @endif
                                        </td>
                                        <td>{{ $item->full_name }}</td>
                                        <td>{{ $item->position }}</td>
                                        <td>{{ $item->order }}</td>
                                        <td>{{ $item->category ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('admin.clergy.edit', $item->id) }}"
                                                class="btn btn-sm btn-outline-primary">Ред.</a>

                                            <form action="{{ route('admin.clergy.destroy', $item->id) }}" method="post"
                                                class="d-inline" onsubmit="return confirm('Удалить запись?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger">Удал.</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Записей не найдено</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection
