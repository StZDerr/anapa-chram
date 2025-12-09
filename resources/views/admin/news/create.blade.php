@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Добавить новость</h5>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary btn-sm">Назад к списку</a>
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

                        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Заголовок</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" placeholder="Введите заголовок"
                                    value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Текст новости</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="6"
                                    placeholder="Введите текст новости...">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Статус</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status">
                                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>
                                        Опубликовано</option>
                                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Черновик
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="published_at" class="form-label">Дата публикации</label>
                                <input type="date" class="form-control" id="published_at" name="published_at"
                                    value="{{ old('published_at') }}">
                                @error('published_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="img_preview" class="form-label">Фотография Превью</label>
                                <input type="file" class="form-control @error('img_preview') is-invalid @enderror"
                                    id="img_preview" name="img_preview" accept="image/*" required>
                                <small class="text-muted">Можно выбрать только один файл!</small>
                                @error('img_preview')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="images" class="form-label">Фотографии новости</label>
                                <input type="file" class="form-control @error('images.*') is-invalid @enderror"
                                    id="images" name="images[]" multiple accept="image/*">
                                <small class="text-muted">Можно выбрать несколько файлов</small>
                                @error('images.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Сохранить</button>

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
            // Функция-инициализация CKEditor (будет вызвана после загрузки скрипта)
            function initCKEditor() {
                // Попробуем получить конструктор: ClassicEditor или CKEDITOR.ClassicEditor
                const EditorCtor = window.ClassicEditor || (window.CKEDITOR && window.CKEDITOR.ClassicEditor);
                if (!EditorCtor) {
                    // если ещё не определён (маловероятно при onload), попробуем через небольшой таймаут
                    setTimeout(initCKEditor, 100);
                    return;
                }

                class MyUploadAdapter {
                    constructor(loader) {
                        this.loader = loader;
                    }

                    upload() {
                        return this.loader.file
                            .then(file => new Promise((resolve, reject) => {
                                const data = new FormData();
                                data.append('upload', file);
                                data.append('_token', '{{ csrf_token() }}');

                                fetch('{{ route('admin.news.upload-image') }}', {
                                        method: 'POST',
                                        body: data,
                                        credentials: 'same-origin'
                                    })
                                    .then(response => response.json())
                                    .then(result => {
                                        if (!result || !result.url) {
                                            return reject('Upload failed');
                                        }
                                        resolve({
                                            default: result.url
                                        });
                                    })
                                    .catch(error => {
                                        reject(error);
                                    });
                            }));
                    }

                    abort() {
                        // можно реализовать отмену при необходимости
                    }
                }

                function MyCustomUploadAdapterPlugin(editor) {
                    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                        return new MyUploadAdapter(loader);
                    };
                }

                // Инициализация редактора
                EditorCtor
                    .create(document.querySelector('#content'), {
                        language: 'ru',
                        extraPlugins: [MyCustomUploadAdapterPlugin],
                        removePlugins: [
                            'RealTimeCollaborativeEditing',
                            'RealTimeCollaborativeComments',
                            'RealTimeCollaborativeTrackChanges',
                            'RealTimeCollaborativeRevisionHistory',
                            'PresenceList',
                            'Comments',
                            'TrackChanges',
                            'TrackChangesData',
                            'RevisionHistory',
                            'Pagination',
                            'WProofreader',
                            'MathType',
                            'SlashCommand',
                            'Template',
                            'DocumentOutline',
                            'FormatPainter',
                            'TableOfContents',
                            'PasteFromOfficeEnhanced',
                            'CaseChange',
                            'AIAssistant',
                            'MultiLevelList'
                        ],
                        toolbar: {
                            items: [
                                'heading', '|',
                                'bold', 'italic', 'underline', 'strikethrough', '|',
                                'alignment:left', 'alignment:center', 'alignment:right', 'alignment:justify',
                                '|',
                                'link', 'bulletedList', 'numberedList', '|',
                                'outdent', 'indent', '|',
                                'uploadImage', 'blockQuote', 'insertTable', '|',
                                'fontSize', 'fontColor', 'fontBackgroundColor', '|',
                                'undo', 'redo', '|',
                                'sourceEditing'
                            ],
                            shouldNotGroupWhenFull: true
                        },
                        alignment: {
                            options: ['left', 'center', 'right', 'justify']
                        },
                        heading: {
                            options: [{
                                    model: 'paragraph',
                                    title: 'Параграф',
                                    class: 'ck-heading_paragraph'
                                },
                                {
                                    model: 'heading1',
                                    view: 'h1',
                                    title: 'Заголовок 1 h1',
                                    class: 'ck-heading_heading1'
                                },
                                {
                                    model: 'heading2',
                                    view: 'h2',
                                    title: 'Заголовок 2 h2',
                                    class: 'ck-heading_heading2'
                                },
                                {
                                    model: 'heading3',
                                    view: 'h3',
                                    title: 'Заголовок 3 h3',
                                    class: 'ck-heading_heading3'
                                },
                                {
                                    model: 'heading4',
                                    view: 'h4',
                                    title: 'Заголовок 4 h4',
                                    class: 'ck-heading_heading4'
                                },
                                {
                                    model: 'heading5',
                                    view: 'h5',
                                    title: 'Заголовок 5 h5',
                                    class: 'ck-heading_heading5'
                                },
                                {
                                    model: 'heading6',
                                    view: 'h6',
                                    title: 'Заголовок 6 h6',
                                    class: 'ck-heading_heading6'
                                }
                            ]
                        },
                        image: {
                            toolbar: [
                                'imageTextAlternative', '|',
                                'imageStyle:inline', 'imageStyle:block', 'imageStyle:alignLeft',
                                'imageStyle:alignCenter', 'imageStyle:alignRight', '|',
                                'toggleImageCaption', 'linkImage', '|',
                                'resizeImage'
                            ],
                            styles: {
                                options: [
                                    'inline', 'block', 'alignLeft', 'alignCenter', 'alignRight'
                                ]
                            },
                            resizeUnit: 'px',
                            resizeOptions: [{
                                    name: 'resizeImage:original',
                                    label: 'Оригинал',
                                    value: null
                                },
                                {
                                    name: 'resizeImage:custom',
                                    label: 'Произвольно',
                                    value: 'custom'
                                },
                                {
                                    name: 'resizeImage:25',
                                    label: '25%',
                                    value: '25'
                                },
                                {
                                    name: 'resizeImage:50',
                                    label: '50%',
                                    value: '50'
                                },
                                {
                                    name: 'resizeImage:75',
                                    label: '75%',
                                    value: '75'
                                }
                            ]
                        }
                    })
                    .then(editor => {
                        // Сохраняем экземпляр редактора глобально для обработчика сабмита
                        window.newsEditor = editor;

                        // Добавляем обработчик submit: валидация и запись HTML в textarea
                        var form = document.querySelector('form[action="{{ route('admin.news.store') }}"]');
                        var textarea = document.getElementById('content');

                        if (form && editor) {
                            form.addEventListener('submit', function(e) {
                                var dataHtml = editor.getData ? editor.getData() : '';
                                // plain text для проверки пустоты
                                var tmp = document.createElement('div');
                                tmp.innerHTML = dataHtml;
                                var plain = (tmp.textContent || tmp.innerText || '').replace(/\s+/g, '')
                                    .trim();

                                if (!plain) {
                                    e.preventDefault();
                                    // показать валидацию
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

                                // очистить предыдущую ошибку
                                textarea.classList.remove('is-invalid');
                                var fb = textarea.nextElementSibling;
                                if (fb && fb.classList && fb.classList.contains('invalid-feedback')) {
                                    fb.parentNode.removeChild(fb);
                                }

                                // записываем HTML в textarea чтобы сервер получил контент
                                textarea.value = dataHtml;
                            });

                            // очистка валидации при изменении
                            try {
                                editor.model.document.on('change:data', function() {
                                    textarea.classList.remove('is-invalid');
                                    var fb = textarea.nextElementSibling;
                                    if (fb && fb.classList && fb.classList.contains('invalid-feedback')) {
                                        fb.parentNode.removeChild(fb);
                                    }
                                });
                            } catch (e) {}
                        }
                    })
                    .catch(error => {
                        console.error('Ошибка инициализации CKEditor:', error);
                    });
            }

            // Динамически загружаем CDN-скрипт CKEditor и запускаем initCKEditor в onload
            var script = document.createElement('script');
            script.src = 'https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js';
            script.onload = initCKEditor;
            script.onerror = function() {
                console.error('Ошибка загрузки CKEditor CDN. Проверьте доступ к https://cdn.ckeditor.com/');
            };
            document.head.appendChild(script);
        })();
    </script>
@endpush
