@extends('layouts.app')

@section('content')
    @php
        $statusColors = [
            'draft' => 'secondary', // серый
            'pending' => 'warning', // желтый
            'published' => 'success', // зеленый
        ];
    @endphp
    <div class="container-fluid">
        <div class="row">
            @include('components.alerts')
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Активности</h5>
                        <a href="{{ route('admin.activity.create') }}" class="btn btn-primary btn-sm">Добавить активность</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Заголовок</th>
                                        <th scope="col">Дата публикации</th>
                                        <th scope="col">Статус</th>
                                        <th scope="col">Превью</th>
                                        <th scope="col">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($activity as $activityItem)
                                        <tr>
                                            <th scope="row">{{ $activityItem->id }}</th>
                                            <td>{{ $activityItem->title }}</td>
                                            <td>{{ $activityItem->published_at }}</td>
                                            <td>
                                                @if ($activityItem->deleted_at)
                                                    <span class="badge bg-danger">Удалена</span>
                                                @else
                                                    <span
                                                        class="badge bg-{{ $statusColors[$activityItem->status] ?? 'secondary' }}">
                                                        {{ $activityItem->status_name }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <img src="{{ asset('storage/' . $activityItem->img_preview) }}"
                                                    alt="Превью" class="img-thumbnail" style="max-width: 100px;">
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.activity.show', $activityItem->id) }}"
                                                    class="btn btn-sm btn-outline-primary">Подробнее</a>
                                                <a href="{{ route('admin.activity.edit', $activityItem->id) }}"
                                                    class="btn btn-sm btn-outline-secondary">Редактировать</a>
                                                <form action="{{ route('admin.activity.destroy', $activityItem->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Удалить новость?')">Удалить</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
