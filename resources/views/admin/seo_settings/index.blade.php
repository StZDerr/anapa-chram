@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>SEO — Настройки</h1>
            <div>
                <a href="{{ route('admin.seo-pages.create') }}" class="btn btn-primary ms-2">Создать SEO-страницу</a>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                @if (isset($setting) && $setting)
                    <form method="POST" action="{{ route('admin.seo-settings.update', $setting->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="global_indexing" id="global_indexing"
                                value="1" {{ $setting->global_indexing ? 'checked' : '' }}>
                            <label class="form-check-label" for="global_indexing">Глобальная индексация (разрешить
                                индексацию)</label>
                        </div>
                        <button class="btn btn-primary">Сохранить</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('admin.seo-settings.store') }}">
                        @csrf
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="global_indexing" id="global_indexing"
                                value="1">
                            <label class="form-check-label" for="global_indexing">Глобальная индексация (разрешить
                                индексацию)</label>
                        </div>
                        <button class="btn btn-primary">Создать</button>
                    </form>
                @endif
                <form action="{{ route('admin.seo-settings.favicon.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div class="mb-3">
                        <label for="favicon" class="form-label">Файл фавикона (ico / png / svg)</label>
                        <input type="file" name="favicon" id="favicon" class="form-control"
                            accept=".ico,image/png,image/svg+xml">
                        @error('favicon')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    @if (!empty($site_settings->favicon))
                        <div class="mb-3">
                            <label class="form-label">Текущий фавикон</label>
                            <div>
                                <img src="{{ asset('storage/' . $site_settings->favicon) }}" alt="favicon"
                                    style="width:32px;height:32px;object-fit:contain;">
                                <span class="ms-2">{{ $site_settings->favicon }}</span>
                            </div>
                        </div>
                    @endif

                    <button class="btn btn-primary">Загрузить</button>
                    <a href="{{ route('admin.seo-settings.index') }}" class="btn btn-outline-secondary">Назад</a>
                </form>
            </div>
        </div>


        <h2 class="mb-3">SEO для страниц</h2>

        @if (isset($pages) && $pages->count())
            <div class="table-responsive">
                <table class="table table-sm table-striped align-middle">
                    <thead>
                        <tr>
                            <th>URL / route</th>
                            <th>Title</th>
                            <th>Описание</th>
                            <th>Robots</th>
                            <th>Canonical</th>
                            <th>OG</th>
                            <th class="text-end">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pages as $page)
                            <tr>
                                <td style="min-width:200px; word-break:break-all;">
                                    {{ $page->slug ?? ($page->path ?? '—') }}
                                </td>
                                <td>{{ $page->title ?: '—' }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($page->description ?: '', 140) }}</td>
                                <td>{{ $page->robots ?: '—' }}</td>
                                <td style="max-width:200px; word-break:break-all;">{{ $page->canonical ?: '—' }}</td>
                                <td>{{ $page->og_title ?: '—' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.seo-pages.edit', $page->id) }}"
                                        class="btn btn-sm btn-outline-primary">Редактировать</a>

                                    <form action="{{ route('admin.seo-pages.destroy', $page->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Вы уверены, что хотите удалить эту SEO-страницу?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Удалить</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">Записей SEO-страниц не найдено.</div>
        @endif
    </div>
@endsection
