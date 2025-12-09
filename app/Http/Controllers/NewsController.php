<?php

namespace App\Http\Controllers;

use App\Models\News;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.news.index', compact('news')); // view resources/views/news/index.blade.php
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'nullable|in:published,draft',
            'published_at' => 'nullable|date',
            'img_preview' => 'required|image|max:5120',
            'images.*' => 'nullable|image|max:5120',
        ]);

        // Сохранить превью
        $previewPath = null;
        if ($request->hasFile('img_preview') && $request->file('img_preview')->isValid()) {
            $file = $request->file('img_preview');
            $filename = date('Ymd_His').'_preview_'.Str::random(8).'.'.$file->getClientOriginalExtension();

            // Сохраняем файл на диск 'public'
            $file->storeAs('news/previews', $filename, 'public');
            $previewPath = 'news/previews/'.$filename;
        }

        // Сохраняем запись новости
        $news = News::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'status' => $request->input('status') ?? 'draft',
            'published_at' => $request->input('published_at') ?: null,
            'img_preview' => $previewPath,
        ]);

        // Сохранить дополнительные изображения (если были)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                if (! $img->isValid()) {
                    continue;
                }
                $filename = date('Ymd_His').'_gallery_'.Str::random(8).'.'.$img->getClientOriginalExtension();
                $img->storeAs('news/images', $filename, 'public');
                $news->images()->create([
                    'path' => 'news/images/'.$filename,
                ]);
            }
        }

        return redirect()->route('admin.news.index')->with('success', 'Новость сохранена');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Получаем запись по id
        $newsItem = News::findOrFail($id); // если не найдено — 404

        // Возвращаем view и передаем запись
        return view('admin.news.show', compact('newsItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $newsItem = News::with('images')->findOrFail($id);

        return view('admin.news.edit', compact('newsItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $news = News::with('images')->findOrFail($id);

        // Валидация
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,pending,published',
            'published_at' => 'nullable|date',
            'img_preview' => 'nullable|image|max:5120',
            'images.*' => 'nullable|image|max:5120',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'integer',
        ]);

        // Получаем старое содержимое для сравнения
        $oldContent = $news->content;
        $newContent = $data['content'];

        // Находим изображения в старом контенте, которых нет в новом
        $oldImages = $this->extractImagesFromHtml($oldContent);
        $newImages = $this->extractImagesFromHtml($newContent);
        $removedImages = array_diff($oldImages, $newImages);

        // Удаляем файлы, которые были удалены из редактора
        foreach ($removedImages as $imageUrl) {
            $this->deleteImageByUrl($imageUrl);
        }

        // Подготовим путь превью (оставим прежний по умолчанию)
        $previewPath = $news->img_preview;

        // Обновляем превью если загружено новое
        if ($request->hasFile('img_preview') && $request->file('img_preview')->isValid()) {
            // Удаляем старое превью с диска
            if ($previewPath && Storage::disk('public')->exists($previewPath)) {
                Storage::disk('public')->delete($previewPath);
            }

            // Сохраняем новое превью (аналогично store)
            $file = $request->file('img_preview');
            $filename = date('Ymd_His').'_preview_'.Str::random(8).'.'.$file->getClientOriginalExtension();
            $file->storeAs('news/previews', $filename, 'public');
            $previewPath = 'news/previews/'.$filename;
        }

        // Обновляем новость (включаем img_preview чтобы сохранить путь)
        $news->update([
            'title' => $data['title'],
            'content' => $newContent,
            'status' => $data['status'],
            'published_at' => $data['published_at'] ?? $news->published_at,
            'img_preview' => $previewPath,
        ]);

        // Удаляем отмеченные изображения галереи
        if (! empty($data['remove_images'])) {
            $imagesToDelete = $news->images()->whereIn('id', $data['remove_images'])->get();
            foreach ($imagesToDelete as $img) {
                if (Storage::disk('public')->exists($img->path)) {
                    Storage::disk('public')->delete($img->path);
                }
                $img->delete();
            }
        }

        // Добавляем новые изображения в галерею
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if (! $image->isValid()) {
                    continue;
                }
                $filename = date('Ymd_His').'_gallery_'.Str::random(8).'.'.$image->getClientOriginalExtension();
                $image->storeAs('public/news/images', $filename);
                $news->images()->create(['path' => 'news/images/'.$filename]);
            }
        }

        return redirect()->route('admin.news.index')
            ->with('success', 'Новость успешно обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        // Удаляем превью
        if ($news->img_preview && Storage::disk('public')->exists($news->img_preview)) {
            Storage::disk('public')->delete($news->img_preview);
        }

        // Удаляем изображения из галереи
        foreach ($news->images as $image) {
            if (Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }
            $image->delete();
        }

        // Удаляем изображения из контента (текстовый редактор)
        $contentImages = $this->extractImagesFromHtml($news->content);
        foreach ($contentImages as $imageUrl) {
            $this->deleteImageByUrl($imageUrl);
        }

        // Помечаем новость как удалённую (soft delete)
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'Новость удалена');
    }

    /**
     * Upload image from CKEditor
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|max:5120', // макс 5MB
        ]);

        $file = $request->file('upload');

        // формируем уникальное имя
        $filename = date('Ymd_His').'_editor_'.Str::random(8).'.'.$file->getClientOriginalExtension();

        // путь в storage/app/public/news/editor (используем диск 'public')
        $file->storeAs('news/editor', $filename, 'public');

        // получаем публичный URL
        $url = Storage::url('news/editor/'.$filename);

        return response()->json(['url' => $url], 200);
    }

    /**
     * Извлекает URLs изображений из HTML контента
     */
    private function extractImagesFromHtml($html)
    {
        $images = [];

        if (empty($html)) {
            return $images;
        }

        // Подавляем предупреждения от DOMDocument
        libxml_use_internal_errors(true);

        $dom = new DOMDocument;
        $dom->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        libxml_clear_errors();

        $imgTags = $dom->getElementsByTagName('img');

        foreach ($imgTags as $img) {
            if ($img instanceof \DOMElement) {
                $src = $img->getAttribute('src');
                if ($src) {
                    $images[] = $src;
                }
            }
        }

        return $images;
    }

    /**
     * Удаляет файл изображения по URL
     */
    private function deleteImageByUrl($url)
    {
        // Преобразуем URL в путь файла
        // Например: /storage/news/editor/20251208_123456_editor_abc123.jpg -> news/editor/20251208_123456_editor_abc123.jpg

        if (Str::startsWith($url, '/storage/')) {
            $path = Str::after($url, '/storage/');
        } elseif (Str::startsWith($url, 'storage/')) {
            $path = Str::after($url, 'storage/');
        } elseif (Str::contains($url, '/storage/')) {
            $path = Str::after($url, '/storage/');
        } else {
            // Если не содержит /storage/, возможно это относительный путь
            $path = $url;
        }

        // Удаляем файл если существует
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
