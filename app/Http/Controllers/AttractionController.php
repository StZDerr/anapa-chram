<?php

namespace App\Http\Controllers;

use App\Models\Attraction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttractionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attractions = Attraction::ordered()->get();

        return view('admin.attraction.index', compact('attractions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.attraction.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:webp|max:200', // WebP, макс. 200 КБ
        ]);

        // Устанавливаем порядок по умолчанию
        $validated['order'] = $validated['order'] ?? 0;

        // Загрузка изображения
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('attractions', 'public');
        }

        // Создание записи
        Attraction::create($validated);

        return redirect()->route('admin.attractions.index')
            ->with('success', 'Достопримечательность успешно создана!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Attraction $attraction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attraction $attraction)
    {
        return view('admin.attraction.edit', compact('attraction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attraction $attraction)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:webp|max:200', // сохраняем текущую логику
        ]);

        $validated['order'] = $validated['order'] ?? 0;

        // Если загружен новый файл — удалить старый и сохранить новый
        if ($request->hasFile('image')) {
            if ($attraction->image) {
                Storage::disk('public')->delete($attraction->image);
            }
            $validated['image'] = $request->file('image')->store('attractions', 'public');
        } elseif ($request->boolean('remove_image')) {
            // Удаление по чекбоксу
            if ($attraction->image) {
                Storage::disk('public')->delete($attraction->image);
            }
            $validated['image'] = null;
        } else {
            // если поле не изменялось — не трогаем его
            unset($validated['image']);
        }

        $attraction->update($validated);

        return redirect()->route('admin.attractions.index')
            ->with('success', 'Достопримечательность успешно обновлена!');
    }

    public function destroy(Attraction $attraction)
    {
        if ($attraction->image) {
            Storage::disk('public')->delete($attraction->image);
        }

        $attraction->delete();

        return redirect()->route('admin.attractions.index')
            ->with('success', 'Достопримечательность успешно удалена!');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:attractions,id',
        ]);

        foreach ($request->order as $index => $id) {
            Attraction::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
