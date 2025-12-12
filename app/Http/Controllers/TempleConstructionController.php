<?php

namespace App\Http\Controllers;

use App\Models\TempleConstruction;
use App\Models\TempleConstructionImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TempleConstructionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $construction = TempleConstruction::with('images')->first();

        return view('admin.TempleConstruct.index', compact('construction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Проверяем, что записи еще нет
        if (TempleConstruction::exists()) {
            return redirect()->route('admin.temple-construction.index')
                ->with('error', 'Запись уже существует. Вы можете только редактировать её.');
        }

        return view('admin.TempleConstruct.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Проверяем, что записи еще нет
        if (TempleConstruction::exists()) {
            return redirect()->route('admin.temple-construction.index')
                ->with('error', 'Запись уже существует.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:webp,jpg,jpeg,png|max:2048',
        ]);

        $construction = TempleConstruction::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);

        // Загружаем изображения если есть
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('temple-construction', 'public');

                TempleConstructionImage::create([
                    'temple_construction_id' => $construction->id,
                    'image' => $path,
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.temple-construction.index')
            ->with('success', 'Запись успешно создана.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TempleConstruction $templeConstruction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TempleConstruction $templeConstruction)
    {
        $templeConstruction->load('images');

        return view('admin.TempleConstruct.edit', compact('templeConstruction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TempleConstruction $templeConstruction)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:webp,jpg,jpeg,png|max:2048',
        ]);

        $templeConstruction->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);

        // Добавляем новые изображения если загружены
        if ($request->hasFile('images')) {
            $maxOrder = $templeConstruction->images()->max('order') ?? -1;

            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('temple-construction', 'public');

                TempleConstructionImage::create([
                    'temple_construction_id' => $templeConstruction->id,
                    'image' => $path,
                    'order' => $maxOrder + $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.temple-construction.edit', $templeConstruction)
            ->with('success', 'Запись успешно обновлена.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TempleConstruction $templeConstruction)
    {
        // Удаляем все связанные изображения с диска
        foreach ($templeConstruction->images as $image) {
            if (Storage::disk('public')->exists($image->image)) {
                Storage::disk('public')->delete($image->image);
            }
        }

        $templeConstruction->delete();

        return redirect()->route('admin.temple-construction.index')
            ->with('success', 'Запись успешно удалена.');
    }

    /**
     * Удаление отдельного изображения
     */
    public function deleteImage(TempleConstructionImage $image)
    {
        if (Storage::disk('public')->exists($image->image)) {
            Storage::disk('public')->delete($image->image);
        }

        $image->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Обновление порядка изображений
     */
    public function updateOrder(Request $request)
    {
        $order = $request->input('order', []);

        foreach ($order as $index => $id) {
            TempleConstructionImage::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
