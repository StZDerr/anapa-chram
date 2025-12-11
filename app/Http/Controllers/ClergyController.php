<?php

namespace App\Http\Controllers;

use App\Models\Clergy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClergyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clergy = Clergy::orderBy('category')->get();

        return view('admin.clergy.index', compact('clergy'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.clergy.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'category' => 'required|in:ДУХОВЕНСТВО ХРАМА,ПЕРСОНАЛ ХРАМА',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('clergy', 'public');
        }

        Clergy::create($data);

        return redirect()->route('admin.clergy.index')->with('success', 'Священнослужитель успешно добавлен.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Clergy $clergy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clergy $clergy)
    {
        return view('admin.clergy.edit', compact('clergy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Clergy $clergy)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'category' => 'required|in:ДУХОВЕНСТВО ХРАМА,ПЕРСОНАЛ ХРАМА',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'remove_image' => 'nullable|boolean',
        ]);

        // Если пользователь явно попросил удалить изображение
        if ($request->boolean('remove_image') && $clergy->image) {
            Storage::disk('public')->delete($clergy->image);
            $data['image'] = null;
        }

        // Если загружен новый файл — сохраняем и заменяем старый
        if ($request->hasFile('image')) {
            if ($clergy->image) {
                Storage::disk('public')->delete($clergy->image);
            }
            $data['image'] = $request->file('image')->store('clergy', 'public');
        }

        // Если ни удаления, ни новой загрузки нет — не трогаем поле image
        if (! $request->hasFile('image') && ! $request->boolean('remove_image')) {
            unset($data['image']);
        }

        $clergy->update($data);

        return redirect()->route('admin.clergy.index')->with('success', 'Запись успешно обновлена.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clergy $clergy)
    {
        if ($clergy->image) {
            Storage::disk('public')->delete($clergy->image);
        }

        $clergy->delete();

        return redirect()->route('admin.clergy.index')->with('success', 'Запись успешно удалена.');
    }
}
