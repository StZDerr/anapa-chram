<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activity = Activity::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.activity.index', compact('activity')); // view resources/views/activity/index.blade.php
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.activity.create');
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
            'img_preview' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
        ]);

        // Инициализируем переменную
        $imgPreviewPath = null;

        // Сохраняем превью
        if ($request->hasFile('img_preview') && $request->file('img_preview')->isValid()) {
            $imgPreviewPath = $request->file('img_preview')->store('activity', 'public');
        }

        // Создаем активность
        $activity = Activity::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'img_preview' => $imgPreviewPath,
            'status' => $data['status'],
            'published_at' => $data['published_at'] ?? now(),
        ]);

        // Сохраняем дополнительные изображения
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $path = $image->store('activity_images', 'public');
                    $activity->images()->create(['path' => $path]);
                }
            }
        }

        return redirect()->route('admin.activity.index')
            ->with('success', 'Активность успешно создана!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Получаем запись по id
        $activity = Activity::findOrFail($id); // если не найдено — 404

        // Возвращаем view и передаем запись
        return view('admin.activity.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $activity = Activity::with('images')->findOrFail($id);

        return view('admin.activity.edit', compact('activity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $activity = Activity::with('images')->findOrFail($id);

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

        // Обновляем активность
        $activity->update([
            'title' => $data['title'],
            'content' => $data['content'],
            'status' => $data['status'],
            'published_at' => $data['published_at'] ?? $activity->published_at,
        ]);

        if ($request->hasFile('img_preview')) {
            // Удаляем старое превью с диска
            if ($activity->img_preview && \Storage::disk('public')->exists($activity->img_preview)) {
                \Storage::disk('public')->delete($activity->img_preview);
            }

            // Сохраняем новое превью
            $activity->img_preview = $request->file('img_preview')->store('activity', 'public');
            $activity->save();
        }
        // Удаляем отмеченные изображения
        if (! empty($data['remove_images'])) {
            $imagesToDelete = $activity->images()->whereIn('id', $data['remove_images'])->get();
            foreach ($imagesToDelete as $img) {
                \Storage::disk('public')->delete($img->path);
                $img->delete();
            }
        }

        // Добавляем новые изображения
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('activity_images', 'public');
                $activity->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.activity.index', $activity->id)
            ->with('success', 'Активность успешно обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy(Activity $activity)
    {
        $activity->delete(); // помечаем удалённой

        return redirect()->route('admin.activity.index')->with('success', 'Активность удалена');
    }
}
