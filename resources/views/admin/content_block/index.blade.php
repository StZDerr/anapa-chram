@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h4 mb-0">Контент-блоки</h1>
            <a href="{{ route('admin.content-blocks.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Добавить блок
            </a>
        </div>

        @if ($blocks->isEmpty())
            <div class="alert alert-info">Блоки не найдены. <a href="{{ route('admin.content-blocks.create') }}">Создать
                    первый</a></div>
        @else
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Заголовок</th>
                                <th class="text-end" style="width:220px;">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($blocks as $block)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $block->title }}</strong>
                                        @if ($block->title_desc)
                                            <div class="text-muted small">{{ $block->title_desc }}</div>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.content-blocks.edit', $block->slug) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i> Редактировать
                                        </a>

                                        <form action="{{ route('admin.content-blocks.destroy', $block->slug) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Удалить блок «{{ addslashes($block->title) }}»?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">
                                                <i class="fas fa-trash"></i> Удалить
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
