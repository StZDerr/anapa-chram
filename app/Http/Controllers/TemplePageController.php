<?php

namespace App\Http\Controllers;

use App\Models\TemplePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TemplePageController extends Controller
{
    /**
     * Show the form for editing the temple page.
     */
    public function edit()
    {
        $page = TemplePage::getByKey('temple_main') ?? new TemplePage(['page_key' => 'temple_main']);

        return view('admin.temple.edit', compact('page'));
    }

    /**
     * Update the temple page content.
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:500',
            'about_text' => 'nullable|string',
            'opening_title' => 'nullable|string|max:500',
            'opening_text' => 'nullable|string',
            'opening_details' => 'nullable|string',
            'gallery_1_images.*' => 'nullable|image|max:5120',
            'gallery_2_images.*' => 'nullable|image|max:5120',
            'remove_gallery_1.*' => 'nullable|string',
            'remove_gallery_2.*' => 'nullable|string',
        ]);

        $page = TemplePage::where('page_key', 'temple_main')->first();

        if (! $page) {
            $page = TemplePage::create([
                'page_key' => 'temple_main',
                'title' => $data['title'] ?? null,
                'about_text' => $data['about_text'] ?? null,
                'opening_title' => $data['opening_title'] ?? null,
                'opening_text' => $data['opening_text'] ?? null,
                'opening_details' => $data['opening_details'] ?? null,
                'gallery_1_images' => [],
                'gallery_2_images' => [],
            ]);
        }

        // Обновляем текстовые поля
        $page->update([
            'title' => $data['title'] ?? $page->title,
            'about_text' => $data['about_text'] ?? $page->about_text,
            'opening_title' => $data['opening_title'] ?? $page->opening_title,
            'opening_text' => $data['opening_text'] ?? $page->opening_text,
            'opening_details' => $data['opening_details'] ?? $page->opening_details,
        ]);

        // Обработка галереи 1
        $gallery1 = $page->gallery_1_images ?? [];

        // Удаляем отмеченные изображения из галереи 1
        if (! empty($data['remove_gallery_1'])) {
            foreach ($data['remove_gallery_1'] as $pathToRemove) {
                if (Storage::disk('public')->exists($pathToRemove)) {
                    Storage::disk('public')->delete($pathToRemove);
                }
                $gallery1 = array_values(array_filter($gallery1, fn ($p) => $p !== $pathToRemove));
            }
        }

        // Добавляем новые изображения в галерею 1
        if ($request->hasFile('gallery_1_images')) {
            foreach ($request->file('gallery_1_images') as $image) {
                if ($image->isValid()) {
                    $filename = date('Ymd_His').'_temple1_'.Str::random(8).'.'.$image->getClientOriginalExtension();
                    $image->storeAs('temple/gallery1', $filename, 'public');
                    $gallery1[] = 'temple/gallery1/'.$filename;
                }
            }
        }

        // Обработка галереи 2
        $gallery2 = $page->gallery_2_images ?? [];

        // Удаляем отмеченные изображения из галереи 2
        if (! empty($data['remove_gallery_2'])) {
            foreach ($data['remove_gallery_2'] as $pathToRemove) {
                if (Storage::disk('public')->exists($pathToRemove)) {
                    Storage::disk('public')->delete($pathToRemove);
                }
                $gallery2 = array_values(array_filter($gallery2, fn ($p) => $p !== $pathToRemove));
            }
        }

        // Добавляем новые изображения в галерею 2
        if ($request->hasFile('gallery_2_images')) {
            foreach ($request->file('gallery_2_images') as $image) {
                if ($image->isValid()) {
                    $filename = date('Ymd_His').'_temple2_'.Str::random(8).'.'.$image->getClientOriginalExtension();
                    $image->storeAs('temple/gallery2', $filename, 'public');
                    $gallery2[] = 'temple/gallery2/'.$filename;
                }
            }
        }

        $page->update([
            'gallery_1_images' => $gallery1,
            'gallery_2_images' => $gallery2,
        ]);

        return redirect()->route('admin.temple.edit')
            ->with('success', 'Страница храма успешно обновлена!');
    }
}
