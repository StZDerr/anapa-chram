@extends('layouts.app')

@section('title', 'Редактировать слайд парка')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Редактировать слайд парка</h5>
                        <a href="{{ route('admin.park.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Назад
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.park.update', $park) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label">Заголовок слайда</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title', $park->title) }}"
                                    placeholder="Например: Крещенский парк">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                @include('admin.partials.editor', [
                                    'id' => 'description',
                                    'name' => 'description',
                                    'value' => old('description', $park->description),
                                    'label' => 'Описание',
                                    'uploadUrl' => url('admin/news/upload-image'),
                                ])
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="link" class="form-label">Ссылка</label>
                                        <input type="text" class="form-control @error('link') is-invalid @enderror"
                                            id="link" name="link" value="{{ old('link', $park->link) }}"
                                            placeholder="/temple или https://...">
                                        @error('link')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="link_text" class="form-label">Текст ссылки</label>
                                        <input type="text" class="form-control @error('link_text') is-invalid @enderror"
                                            id="link_text" name="link_text"
                                            value="{{ old('link_text', $park->link_text ?? 'Узнать больше') }}"
                                            placeholder="Узнать больше">
                                        @error('link_text')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Основное изображение</label>
                                        @if ($park->image)
                                            <div class="mb-2 position-relative d-inline-block">
                                                <img src="{{ $park->image_url }}" alt="Текущее изображение"
                                                    class="img-thumbnail" style="max-height: 150px;">
                                                <div class="form-check mt-1">
                                                    <input type="checkbox" class="form-check-input" id="remove_image"
                                                        name="remove_image" value="1">
                                                    <label class="form-check-label text-danger" for="remove_image">
                                                        <small>Удалить изображение</small>
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                                            id="image" name="image" accept="image/*">
                                        <small class="text-muted">JPG, PNG или WebP. Макс. 5MB. Рекомендуется
                                            1920x1080</small>
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div id="imagePreview" class="mt-2"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="logo" class="form-label">Логотип (иконка)</label>
                                        @if ($park->logo)
                                            <div class="mb-2 position-relative d-inline-block">
                                                <img src="{{ $park->logo_url }}" alt="Текущий логотип"
                                                    class="img-thumbnail" style="max-height: 80px;">
                                                <div class="form-check mt-1">
                                                    <input type="checkbox" class="form-check-input" id="remove_logo"
                                                        name="remove_logo" value="1">
                                                    <label class="form-check-label text-danger" for="remove_logo">
                                                        <small>Удалить логотип</small>
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                        <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                            id="logo" name="logo" accept="image/*">
                                        <small class="text-muted">JPG, PNG, WebP или SVG. Макс. 2MB</small>
                                        @error('logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div id="logoPreview" class="mt-2"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="order" class="form-label">Порядок отображения</label>
                                        <input type="number" class="form-control @error('order') is-invalid @enderror"
                                            id="order" name="order" value="{{ old('order', $park->order) }}"
                                            min="0">
                                        @error('order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label d-block">Статус</label>
                                        <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input" id="is_active"
                                                name="is_active" value="1"
                                                {{ old('is_active', $park->is_active) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">Активен (показывать на
                                                сайте)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Сохранить изменения
                                </button>
                                <a href="{{ route('admin.park.index') }}" class="btn btn-outline-secondary">Отмена</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Превью текущего слайда -->
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Превью слайда</h6>
                    </div>
                    <div class="card-body p-0" style="background: #333;">
                        <div style="position: relative; aspect-ratio: 16/9; overflow: hidden;">
                            @if ($park->image)
                                <img src="{{ $park->image_url }}" alt="{{ $park->title }}"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100 bg-secondary">
                                    <span class="text-white">Нет изображения</span>
                                </div>
                            @endif
                            <div
                                style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.7)); padding: 15px; color: white;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    @if ($park->logo)
                                        <img src="{{ $park->logo_url }}" alt="Logo"
                                            style="width: 40px; height: 40px;">
                                    @endif
                                    <h6 class="mb-0">{{ $park->title ?? 'Заголовок' }}</h6>
                                </div>
                                <div style="position: absolute; bottom: 15px; left: 15px; right: 15px;">
                                    @if ($park->description)
                                        <p style="font-size: 12px; margin-bottom: 10px;">
                                            {!! \Purifier::clean($park->description) !!}
                                        </p>
                                    @endif
                                    @if ($park->link)
                                        <span
                                            style="font-size: 12px; color: #ccc;">{{ $park->link_text ?? 'Узнать больше' }}
                                            →</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Превью изображений
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            preview.innerHTML = '';

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-thumbnail';
                    img.style.maxHeight = '150px';
                    preview.appendChild(img);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.getElementById('image').addEventListener('change', function() {
            previewImage(this, 'imagePreview');
        });

        document.getElementById('logo').addEventListener('change', function() {
            previewImage(this, 'logoPreview');
        });
    </script>
@endpush
