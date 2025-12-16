@php
    // parameters: $id (string), $name (string), $value (string|null), $label (optional), $uploadUrl (optional)
    $id = $id ?? 'editor';
    $name = $name ?? 'content';
    $value = $value ?? '';
    $label = $label ?? null;
    $uploadUrl = $uploadUrl ?? url('admin/news/upload-image');
@endphp

@if ($label)
    <div class="mb-3">
        <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    </div>
@endif
<textarea class="form-control" id="{{ $id }}" name="{{ $name }}">{{ old($name, $value) }}</textarea>

@push('styles')
    <style>
        /* Минимальная высота редактора */
        .ck-editor__editable[role="textbox"] {
            min-height: 300px;
            max-height: 1200px;
        }

        /* Стили для выравнивания изображений */
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
            const editorId = '{{ $id }}';
            const uploadUrl = '{{ $uploadUrl }}';

            function initEditorFor(id) {
                const textarea = document.getElementById(id);
                console.log('[editor] initEditorFor start', id, !!textarea);
                if (!textarea) return;

                const EditorCtor = window.ClassicEditor || (window.CKEDITOR && window.CKEDITOR.ClassicEditor);
                if (!EditorCtor) {
                    // load script if not present
                    if (!document.querySelector(
                            'script[src="https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js"]')) {
                        console.log('[editor] adding CKEditor script element');
                        var script = document.createElement('script');
                        script.src = 'https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js';
                        script.onload = function() {
                            console.log('[editor] CKEditor script loaded');
                            setTimeout(function() {
                                initEditorFor(id);
                            }, 50);
                        };
                        script.onerror = function() {
                            console.error('Ошибка загрузки CKEditor CDN.');
                        };
                        document.head.appendChild(script);
                    } else {
                        console.log('[editor] CKEditor present but not ready, retrying');
                        setTimeout(function() {
                            initEditorFor(id);
                        }, 100);
                    }
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
                            fetch(uploadUrl, {
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

                // Create editor
                EditorCtor.create(textarea, {
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
                        resizeUnit: 'px'
                    }
                }).then(editor => {
                    console.log('[editor] CKEditor initialized for', id);
                    window.editors = window.editors || {};
                    window.editors[id] = editor;

                    const form = textarea.closest('form');
                    if (form) {
                        form.addEventListener('submit', function(e) {
                            const dataHtml = editor.getData ? editor.getData() : '';
                            const tmp = document.createElement('div');
                            tmp.innerHTML = dataHtml;
                            const plain = (tmp.textContent || tmp.innerText || '').replace(/\s+/g, '')
                                .trim();
                            if (!plain) {
                                e.preventDefault();
                                textarea.classList.add('is-invalid');
                                let feedback = textarea.nextElementSibling;
                                if (!feedback || !feedback.classList || !feedback.classList.contains(
                                        'invalid-feedback')) {
                                    feedback = document.createElement('div');
                                    feedback.className = 'invalid-feedback';
                                    textarea.parentNode.insertBefore(feedback, textarea.nextSibling);
                                }
                                feedback.textContent = 'Поле не может быть пустым.';
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
                                const fb = textarea.nextElementSibling;
                                if (fb && fb.classList && fb.classList.contains('invalid-feedback')) fb
                                    .parentNode.removeChild(fb);
                            });
                        } catch (e) {}
                    }
                }).catch(error => console.error('Ошибка инициализации CKEditor:', error));
            }

            // Initialize
            initEditorFor(editorId);
        })();
    </script>
@endpush
