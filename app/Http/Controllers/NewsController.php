<?php

namespace App\Http\Controllers;

use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        // Валидация
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,pending,published',
            'published_at' => 'nullable|date',
            'img_preview' => 'required|image|max:2048',
            'images.*' => 'image|max:2048', // каждая картинка до 2MB
        ]);

        if ($request->hasFile('img_preview')) {
            // Сохраняем файл в storage/app/public/news
            $imgPreviewPath = $request->file('img_preview')->store('news', 'public');
        }

        // Создаем новость
        $news = News::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'img_preview' => $imgPreviewPath,
            'status' => $data['status'],
            'published_at' => $data['published_at'] ?? Carbon::today(),
        ]);

        // Сохраняем изображения, если они есть
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('news_images', 'public'); // сохраняем в storage/app/public/news_images
                $news->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.news.index')
            ->with('success', 'Новость успешно создана!');
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
            'img_preview' => 'nullable|image|max:2048',
            'images.*' => 'image|max:2048',
            'remove_images' => 'array',
            'remove_images.*' => 'integer',
        ]);

        // Обновляем новость
        $news->update([
            'title' => $data['title'],
            'content' => $data['content'],
            'status' => $data['status'],
            'published_at' => $data['published_at'] ?? $news->published_at,
        ]);

        if ($request->hasFile('img_preview')) {
            // Удаляем старое превью с диска
            if ($news->img_preview && \Storage::disk('public')->exists($news->img_preview)) {
                \Storage::disk('public')->delete($news->img_preview);
            }

            // Сохраняем новое превью
            $news->img_preview = $request->file('img_preview')->store('news', 'public');
            $news->save();
        }
        // Удаляем отмеченные изображения
        if (! empty($data['remove_images'])) {
            $imagesToDelete = $news->images()->whereIn('id', $data['remove_images'])->get();
            foreach ($imagesToDelete as $img) {
                \Storage::disk('public')->delete($img->path);
                $img->delete();
            }
        }

        // Добавляем новые изображения
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('news_images', 'public');
                $news->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.news.index', $news->id)
            ->with('success', 'Новость успешно обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        $news->delete(); // помечаем удалённой

        return redirect()->route('admin.news.index')->with('success', 'Новость удалена');
    }
}
