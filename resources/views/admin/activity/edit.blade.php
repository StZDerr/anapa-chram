@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Редактировать новость</h5>
                        <a href="{{ route('admin.activity.index') }}" class="btn btn-outline-secondary btn-sm">Назад к
                            списку</a>
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

                        <form action="{{ route('admin.activity.update', $item->id) }}" method="POST"
                            enctype="multipart/form-data" id="news-edit-form">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label">Заголовок</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" placeholder="Введите заголовок"
                                    value="{{ old('title', $item->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Текст новости</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="6"
                                    placeholder="Введите текст новости...">{{ old('content', $item->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Статус</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status">
                                    <option value="published"
                                        {{ old('status', $item->status) === 'published' ? 'selected' : '' }}>
                                        Опубликовано</option>
                                    <option value="draft" {{ old('status', $item->status) === 'draft' ? 'selected' : '' }}>
                                        Черновик
                                    </option>
                                    <option value="pending"
                                        {{ old('status', $item->status) === 'pending' ? 'selected' : '' }}>На модерации
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="published_at" class="form-label">Дата публикации</label>
                                <input type="date" class="form-control @error('published_at') is-invalid @enderror"
                                    id="published_at" name="published_at"
                                    value="{{ old('published_at', $item->published_at ? \Illuminate\Support\Carbon::parse($item->published_at)->format('Y-m-d') : '') }}">
                                @error('published_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="img_preview" class="form-label">Фотография Превью</label>
                                <input type="file" class="form-control @error('img_preview') is-invalid @enderror"
                                    id="img_preview" name="img_preview" accept="image/*">
                                <small class="text-muted">Можно выбрать только один файл</small>
                                @error('img_preview')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if ($item->img_preview)
                                    <div class="mt-2" style="max-width: 300px;">
                                        <img src="{{ Storage::disk('public')->exists($item->img_preview) ? Storage::url($item->img_preview) : asset('images/placeholder.png') }}"
                                            alt="Превью новости" class="img-thumbnail w-100"
                                            style="object-fit: cover; height: 180px;">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                id="remove_preview" name="remove_preview">
                                            <label class="form-check-label" for="remove_preview">Удалить старое
                                                превью</label>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="images" class="form-label">Фотографии новости</label>
                                <input type="file" class="form-control @error('images.*') is-invalid @enderror"
                                    id="images" name="images[]" multiple accept="image/*">
                                <small class="text-muted">Можно выбрать несколько файлов</small>
                                @error('images.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if ($item->images && $item->images->count())
                                    <div class="mt-2 d-flex flex-wrap gap-3" id="news-images-list"
                                        style="--img-thumb-width: 23%;">
                                        @foreach ($item->images as $image)
                                            <div class="position-relative news-image-thumb"
                                                data-image-id="{{ $image->id }}"
                                                style="width: var(--img-thumb-width); min-width: 180px; max-width: 260px;">
                                                <img src="{{ Storage::disk('public')->exists($image->path) ? Storage::url($image->path) : asset('images/placeholder.png') }}"
                                                    alt="Фото новости" class="img-thumbnail w-100"
                                                    style="object-fit:cover; height:150px;">
                                                <button type="button"
                                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 news-image-remove-btn"
                                                    style="z-index:2; border-radius:50%; padding:0.2rem 0.45rem; font-size:1rem; line-height:1;">&times;</button>
                                                <input type="hidden" name="remove_images[]" value="" disabled>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">Сохранить изменения</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Минимальная высота редактора */
        .ck-editor__editable[role="textbox"] {
            min-height: 400px;
            max-height: 1200px;
        }

        /* Стили для выравнивания изображений (обтекание текстом) */
        .ck-content .image-style-align-left {
            float: left;
            margin-right: 1.5em;
            margin-bottom: 1em;
        }

        .ck-content .image-style-align-right {
            float: right;
            margin-left: 1.5em;
            margin-bottom: 1em;
        }

        .ck-content .image-style-align-center {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .ck-content .image {
            display: table;
            clear: both;
            text-align: center;
            margin: 1em auto;
        }

        .ck-content .image img {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            height: auto;
        }

        /* Очистка float после изображения */
        .ck-content::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
@endpush

@push('scripts')
    <script>
        (function() {
            function initCKEditor() {
                const EditorCtor = window.ClassicEditor || (window.CKEDITOR && window.CKEDITOR.ClassicEditor);
                if (!EditorCtor) {
                    setTimeout(initCKEditor, 100);
                    return;
                }

                class MyUploadAdapter {
                    constructor(loader) {
                        this.loader = loader;
                    }
                    upload() {
                        return this.loader.file.then(file => new Promise((resolve, reject) => {
                            const data = new FormData();
                            data.append('upload', file);
                            data.append('_token', '{{ csrf_token() }}');
                            fetch('{{ route('admin.activity.upload-image') }}', {
                                    method: 'POST',
                                    body: data,
                                    credentials: 'same-origin'
                                })
                                .then(r => r.json()).then(result => {
                                    if (!result || !result.url) return reject('Upload failed');
                                    resolve({
                                        default: result.url
                                    });
                                }).catch(reject);
                        }));
                    }
                    abort() {}
                }

                function MyCustomUploadAdapterPlugin(editor) {
                    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => new MyUploadAdapter(loader);
                }

                EditorCtor.create(document.querySelector('#content'), {
                    language: 'ru',
                    extraPlugins: [MyCustomUploadAdapterPlugin],
                    removePlugins: ['RealTimeCollaborativeEditing', 'RealTimeCollaborativeComments',
                        'RealTimeCollaborativeTrackChanges', 'RealTimeCollaborativeRevisionHistory',
                        'PresenceList', 'Comments', 'TrackChanges', 'TrackChangesData', 'RevisionHistory',
                        'Pagination', 'WProofreader', 'MathType', 'SlashCommand', 'Template',
                        'DocumentOutline', 'FormatPainter', 'TableOfContents', 'PasteFromOfficeEnhanced',
                        'CaseChange', 'AIAssistant', 'MultiLevelList'
                    ],
                    toolbar: {
                        items: ['heading', '|', 'bold', 'italic', 'underline', 'strikethrough', '|',
                            'alignment:left', 'alignment:center', 'alignment:right', 'alignment:justify',
                            '|', 'link', 'bulletedList', 'numberedList', '|', 'outdent', 'indent', '|',
                            'uploadImage', 'blockQuote', 'insertTable', '|', 'fontSize', 'fontColor',
                            'fontBackgroundColor', '|', 'undo', 'redo', '|', 'sourceEditing'
                        ],
                        shouldNotGroupWhenFull: true
                    },
                    alignment: {
                        options: ['left', 'center', 'right', 'justify']
                    },
                    heading: {
                        options: [{
                            model: 'paragraph',
                            title: 'Параграф'
                        }, {
                            model: 'heading1',
                            view: 'h1',
                            title: 'Заголовок 1 h1'
                        }, {
                            model: 'heading2',
                            view: 'h2',
                            title: 'Заголовок 2 h2'
                        }]
                    },
                    image: {
                        toolbar: ['imageTextAlternative', '|', 'imageStyle:inline', 'imageStyle:block',
                            'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight', '|',
                            'toggleImageCaption', 'linkImage', '|', 'resizeImage'
                        ],
                        styles: {
                            options: ['inline', 'block', 'alignLeft', 'alignCenter', 'alignRight']
                        },
                        resizeUnit: 'px',
                        resizeOptions: [{
                            name: 'resizeImage:original',
                            label: 'Оригинал',
                            value: null
                        }, {
                            name: 'resizeImage:custom',
                            label: 'Произвольно',
                            value: 'custom'
                        }, {
                            name: 'resizeImage:25',
                            label: '25%',
                            value: '25'
                        }, {
                            name: 'resizeImage:50',
                            label: '50%',
                            value: '50'
                        }, {
                            name: 'resizeImage:75',
                            label: '75%',
                            value: '75'
                        }]
                    }
                }).then(editor => {
                    window.newsEditor = editor;
                    var form = document.getElementById('news-edit-form');
                    var textarea = document.getElementById('content');
                    if (form && editor) {
                        form.addEventListener('submit', function(e) {
                            var dataHtml = editor.getData ? editor.getData() : '';
                            var tmp = document.createElement('div');
                            tmp.innerHTML = dataHtml;
                            var plain = (tmp.textContent || tmp.innerText || '').replace(/\s+/g, '')
                                .trim();
                            if (!plain) {
                                e.preventDefault();
                                textarea.classList.add('is-invalid');
                                var feedback = textarea.nextElementSibling;
                                if (!feedback || !feedback.classList || !feedback.classList.contains(
                                        'invalid-feedback')) {
                                    feedback = document.createElement('div');
                                    feedback.className = 'invalid-feedback';
                                    textarea.parentNode.insertBefore(feedback, textarea.nextSibling);
                                }
                                feedback.textContent = 'Поле "Текст новости" не может быть пустым.';
                                textarea.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });
                                return false;
                            }
                            textarea.value = dataHtml;
                        });
                        try {
                            editor.model.document.on('change:data', function() {
                                textarea.classList.remove('is-invalid');
                                var fb = textarea.nextElementSibling;
                                if (fb && fb.classList && fb.classList.contains('invalid-feedback')) fb
                                    .parentNode.removeChild(fb);
                            });
                        } catch (e) {}
                    }
                }).catch(error => console.error('Ошибка инициализации CKEditor:', error));
            }
            var script = document.createElement('script');
            script.src = 'https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js';
            script.onload = initCKEditor;
            script.onerror = function() {
                console.error('Ошибка загрузки CKEditor CDN. Проверьте доступ к https://cdn.ckeditor.com/');
            };
            document.head.appendChild(script);

            // Галерея — пометка на удаление
            document.addEventListener('DOMContentLoaded', function() {
                const imagesList = document.getElementById('news-images-list');
                if (imagesList) {
                    imagesList.querySelectorAll('.news-image-remove-btn').forEach(function(btn) {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            const thumb = btn.closest('.news-image-thumb');
                            thumb.classList.toggle('opacity-50');
                            const input = thumb.querySelector('input[name="remove_images[]"]');
                            if (thumb.classList.contains('opacity-50')) {
                                input.value = thumb.dataset.imageId;
                                input.disabled = false;
                            } else {
                                input.value = '';
                                input.disabled = true;
                            }
                        });
                    });
                }

                const removePreviewCheckbox = document.getElementById('remove_preview');
                if (removePreviewCheckbox) {
                    removePreviewCheckbox.addEventListener('change', function() {
                        /* visual placeholder can be added */
                    });
                }
            });

        })();
    </script>
@endpush
