@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-header">
                <h5>{{ $newsItem->title }}</h5>
            </div>
            <div class="card-body">
                <p><strong>Дата публикации:</strong> {{ $newsItem->published_at }}</p>
                <p><strong>Статус:</strong> {{ $newsItem->status_name }}</p>
                <hr>
                <p>{{ $newsItem->content }}</p>

                @if ($newsItem->images)
                    <div class="mt-3 d-flex flex-wrap gap-3">
                        @foreach ($newsItem->images as $image)
                            <div style="max-width: 180px;">
                                <img src="{{ asset('storage/' . $image->path) }}" alt="Фото новости"
                                    class="img-thumbnail mb-1 w-100" style="object-fit:cover; height:120px;">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.news.index') }}" class="btn btn-secondary btn-sm">Назад к списку</a>
            </div>
        </div>
    </div>
@endsection
