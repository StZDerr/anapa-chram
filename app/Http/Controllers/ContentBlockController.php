<?php

namespace App\Http\Controllers;

use App\Models\ContentBlock;
use App\Models\ContentBlockImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContentBlockController extends Controller
{
    public function index()
    {
        $blocks = ContentBlock::with('images')->get();

        return view('admin.content_block.index', compact('blocks'));
    }

    public function create()
    {
        return view('admin.content_block.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'title_desc' => 'nullable|string',
            'desc' => 'nullable|string',
            'block_2_title' => 'nullable|string|max:255',
            'block_2_desc' => 'nullable|string',
            'block_2_img' => 'nullable|image|mimes:webp,jpg,jpeg,png|max:2048',
            'images.*' => 'nullable|image|mimes:webp,jpg,jpeg,png|max:2048',
            'price' => 'nullable|numeric|min:0',
            'preview_img' => 'nullable|image|mimes:webp,jpg,jpeg,png|max:2048',
        ]);

        // Чистка HTML (если установлен Purifier) — fallback на strip_tags с разрешёнными тегами
        $clean = function ($html) {
            if (class_exists(\Mews\Purifier\Facades\Purifier::class)) {
                return \Mews\Purifier\Facades\Purifier::clean($html ?? '');
            }
            $allowed = '<p><a><br><strong><em><ul><ol><li><img><h1><h2><h3><blockquote>';

            return strip_tags($html ?? '', $allowed);
        };

        $block = ContentBlock::create([
            'title' => $validated['title'],
            'title_desc' => $validated['title_desc'] ?? null,
            'desc' => $clean($validated['desc'] ?? null),
            'block_2_title' => $validated['block_2_title'] ?? null,
            'block_2_desc' => $clean($validated['block_2_desc'] ?? null),
            'block_2_img' => null,
            'price' => $validated['price'] ?? null,
        ]);

        // Загрузить block_2_img (если есть)
        if ($request->hasFile('block_2_img')) {
            $path = $request->file('block_2_img')->store('content-blocks', 'public');
            $block->update(['block_2_img' => $path]);
        }

        if ($request->hasFile('preview_img')) {
            $path = $request->file('preview_img')->store('content-blocks', 'public');
            $block->update(['preview_img' => $path]);
        }

        // Загрузить изображения (gallery)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('content-blocks', 'public');
                ContentBlockImage::create([
                    'content_block_id' => $block->id,
                    'img' => $path,
                    'sort' => $index,
                ]);
            }
        }

        return redirect()->route('admin.content-blocks.index')->with('success', 'Блок сохранён.');
    }

    public function show(ContentBlock $contentBlock)
    {
        return view('admin.content_block.show', compact('contentBlock'));
    }

    public function edit(ContentBlock $contentBlock)
    {
        $contentBlock->load('images');

        return view('admin.content_block.edit', compact('contentBlock'));
    }

    public function update(Request $request, ContentBlock $contentBlock)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'title_desc' => 'nullable|string',
            'desc' => 'nullable|string',
            'block_2_title' => 'nullable|string|max:255',
            'block_2_desc' => 'nullable|string',
            'block_2_img' => 'nullable|image|mimes:webp,jpg,jpeg,png|max:2048',
            'images.*' => 'nullable|image|mimes:webp,jpg,jpeg,png|max:2048',
            'price' => 'nullable|numeric|min:0',
            'preview_img' => 'nullable|image|mimes:webp,jpg,jpeg,png|max:2048',
        ]);

        $clean = function ($html) {
            if (class_exists(\Mews\Purifier\Facades\Purifier::class)) {
                return \Mews\Purifier\Facades\Purifier::clean($html ?? '');
            }
            $allowed = '<p><a><br><strong><em><ul><ol><li><img><h1><h2><h3><blockquote>';

            return strip_tags($html ?? '', $allowed);
        };

        if ($contentBlock->title !== $validated['title']) {
            $base = Str::slug($validated['title'] ?? 'block');
            $slug = $base;
            $i = 1;
            while (ContentBlock::where('slug', $slug)->where('id', '!=', $contentBlock->id)->exists()) {
                $slug = $base.'-'.$i++;
            }
        } else {
            $slug = $contentBlock->slug; // не трогаем, если заголовок не менялся
        }
        $contentBlock->update([
            'title' => $validated['title'],
            'title_desc' => $validated['title_desc'] ?? null,
            'desc' => $clean($validated['desc'] ?? null),
            'block_2_title' => $validated['block_2_title'] ?? null,
            'block_2_desc' => $clean($validated['block_2_desc'] ?? null),
            'slug' => $slug,
            'price' => $validated['price'] ?? null,
        ]);

        // Block 2 image replace
        if ($request->hasFile('block_2_img')) {
            if ($contentBlock->block_2_img && Storage::disk('public')->exists($contentBlock->block_2_img)) {
                Storage::disk('public')->delete($contentBlock->block_2_img);
            }
            $path = $request->file('block_2_img')->store('content-blocks', 'public');
            $contentBlock->update(['block_2_img' => $path]);
        }

        // Preview image replace
        if ($request->hasFile('preview_img')) {
            if ($contentBlock->preview_img && Storage::disk('public')->exists($contentBlock->preview_img)) {
                Storage::disk('public')->delete($contentBlock->preview_img);
            }
            $path = $request->file('preview_img')->store('content-blocks', 'public');
            $contentBlock->update(['preview_img' => $path]);
        }

        // Optionally: remove preview if checkbox checked
        if ($request->boolean('remove_preview_img')) {
            if ($contentBlock->preview_img && Storage::disk('public')->exists($contentBlock->preview_img)) {
                Storage::disk('public')->delete($contentBlock->preview_img);
            }
            $contentBlock->update(['preview_img' => null]);
        }

        // Добавляем новые изображения
        if ($request->hasFile('images')) {
            $max = $contentBlock->images()->max('sort') ?? -1;
            foreach ($request->file('images') as $i => $image) {
                $path = $image->store('content-blocks', 'public');
                ContentBlockImage::create([
                    'content_block_id' => $contentBlock->id,
                    'img' => $path,
                    'sort' => $max + $i + 1,
                ]);
            }
        }

        return redirect()->route('admin.content-blocks.edit', $contentBlock)->with('success', 'Блок обновлён.');
    }

    public function destroy(ContentBlock $contentBlock)
    {
        // Удаляем все изображения с диска
        foreach ($contentBlock->images as $img) {
            if (Storage::disk('public')->exists($img->img)) {
                Storage::disk('public')->delete($img->img);
            }
        }
        // Также удалить block_2_img
        if ($contentBlock->block_2_img && Storage::disk('public')->exists($contentBlock->block_2_img)) {
            Storage::disk('public')->delete($contentBlock->block_2_img);
        }

        // Удаляем preview_img, если есть
        if ($contentBlock->preview_img && Storage::disk('public')->exists($contentBlock->preview_img)) {
            Storage::disk('public')->delete($contentBlock->preview_img);
        }

        $contentBlock->delete();

        return redirect()->route('admin.content-blocks.index')->with('success', 'Блок удалён.');
    }

    // Удаление отдельного изображения (AJAX)
    public function deleteImage(ContentBlockImage $image)
    {
        if (Storage::disk('public')->exists($image->img)) {
            Storage::disk('public')->delete($image->img);
        }
        $image->delete();

        return response()->json(['success' => true]);
    }

    // Обновление порядка изображений (AJAX)
    public function updateOrder(Request $request)
    {
        $order = $request->input('order', []);
        foreach ($order as $index => $id) {
            ContentBlockImage::where('id', $id)->update(['sort' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
