@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-header">
                <h5>{{ $activity->title }}</h5>
            </div>
            <div class="card-body">
                <p><strong>Дата публикации:</strong> {{ $activity->published_at }}</p>
                <p><strong>Статус:</strong> {{ $activity->status_name }}</p>
                <hr>
                <p>{{ $activity->content }}</p>

                @if ($activity->images)
                    <div class="mt-3 d-flex flex-wrap gap-3">
                        @foreach ($activity->images as $image)
                            <div style="max-width: 180px;">
                                <img src="{{ asset('storage/' . $image->path) }}" alt="Фото новости"
                                    class="img-thumbnail mb-1 w-100" style="object-fit:cover; height:120px;">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.activity.index') }}" class="btn btn-secondary btn-sm">Назад к списку</a>
            </div>
        </div>
    </div>
@endsection
