<?php

namespace App\Http\Controllers;

use App\Models\Park;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ParkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slides = Park::ordered()->get();

        return view('admin.park.index', compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.park.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'link_text' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,webp,svg|max:2048',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? 0;
        $validated['link_text'] = $validated['link_text'] ?? 'Узнать больше';

        // Загрузка изображения
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('park', 'public');
        }

        // Загрузка логотипа
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('park/logos', 'public');
        }

        Park::create($validated);

        return redirect()->route('admin.park.index')
            ->with('success', 'Слайд успешно создан');
    }

    /**
     * Display the specified resource.
     */
    public function show(Park $park)
    {
        return redirect()->route('admin.park.edit', $park);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Park $park)
    {
        return view('admin.park.edit', compact('park'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Park $park)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'link_text' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,webp,svg|max:2048',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['link_text'] = $validated['link_text'] ?? 'Узнать больше';

        // Загрузка нового изображения
        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            if ($park->image) {
                Storage::disk('public')->delete($park->image);
            }
            $validated['image'] = $request->file('image')->store('park', 'public');
        }

        // Загрузка нового логотипа
        if ($request->hasFile('logo')) {
            // Удаляем старый логотип
            if ($park->logo) {
                Storage::disk('public')->delete($park->logo);
            }
            $validated['logo'] = $request->file('logo')->store('park/logos', 'public');
        }

        // Удаление изображения по запросу
        if ($request->has('remove_image') && $request->remove_image) {
            if ($park->image) {
                Storage::disk('public')->delete($park->image);
            }
            $validated['image'] = null;
        }

        // Удаление логотипа по запросу
        if ($request->has('remove_logo') && $request->remove_logo) {
            if ($park->logo) {
                Storage::disk('public')->delete($park->logo);
            }
            $validated['logo'] = null;
        }

        $park->update($validated);

        return redirect()->route('admin.park.index')
            ->with('success', 'Слайд успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Park $park)
    {
        // Удаляем изображения
        if ($park->image) {
            Storage::disk('public')->delete($park->image);
        }
        if ($park->logo) {
            Storage::disk('public')->delete($park->logo);
        }

        $park->delete();

        return redirect()->route('admin.park.index')
            ->with('success', 'Слайд успешно удален');
    }

    /**
     * Обновить порядок слайдов (AJAX)
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:parks,id',
        ]);

        foreach ($request->order as $index => $id) {
            Park::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
