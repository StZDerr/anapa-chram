@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('components.alerts')
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Православный календарь</h5>
                        <a href="{{ route('admin.orthodox_calendar.create') }}" class="btn btn-primary btn-sm">Добавить
                            запись</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Дата</th>
                                        <th scope="col">Заголовок</th>
                                        <th scope="col">Описание</th>
                                        <th scope="col">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($calendars as $item)
                                        <tr>
                                            <th scope="row">{{ $item->id }}</th>
                                            <td>{{ $item->date }}</td>
                                            <td>{{ $item->title }}</td>
                                            <td
                                                style="max-width: 40ch; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $item->description }}</td>
                                            <td>
                                                <a href="{{ route('admin.orthodox_calendar.show', $item->id) }}"
                                                    class="btn btn-sm btn-outline-primary">Подробнее</a>
                                                <a href="{{ route('admin.orthodox_calendar.edit', $item->id) }}"
                                                    class="btn btn-sm btn-outline-secondary">Редактировать</a>
                                                <form action="{{ route('admin.orthodox_calendar.destroy', $item->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Удалить запись?')">Удалить</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            {{-- pagination, if provided by controller --}}
                            @if (method_exists($calendars, 'links'))
                                {{ $calendars->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
