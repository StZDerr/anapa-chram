<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\PhotoCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Photo::with('category');

        // Фильтр по категории
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $photos = $query->orderBy('created_at', 'desc')->paginate(20);

        // Получаем категории с количеством фото
        $categories = PhotoCategory::withCount('photos')->orderBy('name')->get();

        return view('admin.gallery.index', compact('photos', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = PhotoCategory::orderBy('name')->get();

        return view('admin.gallery.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'category_id' => 'required|exists:photo_categories,id',
            'image' => 'required|mimes:webp|file|max:200', // только WebP, макс 200 KB
        ]);

        // Сохраняем файл в storage/app/public/gallery
        $file = $request->file('image');
        $path = $file->store('gallery', 'public');

        // Создаём запись
        $photo = Photo::create([
            'title' => $data['title'] ?? null,
            'file_path' => $path,
            'category_id' => $data['category_id'],
        ]);

        return redirect()->route('admin.gallery.index')->with('success', 'Фото успешно добавлено.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $photo = Photo::findOrFail($id);
        $categories = PhotoCategory::orderBy('name')->get();

        return view('admin.gallery.edit', compact('photo', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $photo = Photo::findOrFail($id);

        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'category_id' => ['required', Rule::exists('photo_categories', 'id')],
            'image' => 'nullable|mimes:webp|file|max:200', // только WebP, макс 200 KB
        ]);

        // Обновляем поля
        $photo->title = $data['title'] ?? $photo->title;
        $photo->category_id = $data['category_id'];

        // Если загружен новый файл — сохраняем и удаляем старый
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('gallery', 'public');

            // удалить старый файл, если он есть
            if ($photo->file_path && Storage::disk('public')->exists($photo->file_path)) {
                Storage::disk('public')->delete($photo->file_path);
            }

            $photo->file_path = $path;
        }

        $photo->save();

        return redirect()->route('admin.gallery.index')->with('success', 'Фото обновлено.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $photo = Photo::findOrFail($id);

        // удалить файл с диска
        if ($photo->file_path && Storage::disk('public')->exists($photo->file_path)) {
            Storage::disk('public')->delete($photo->file_path);
        }

        $photo->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Фото удалено.');
    }
}
