<?php

namespace App\Http\Controllers;

use App\Models\SeoPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SeoPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.seo_pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'slug' => 'nullable|string|max:255|unique:seo_pages,slug',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'keywords' => 'nullable|string|max:255',
            'h1' => 'nullable|string|max:255',
            'canonical' => 'nullable|url|max:1000',
            'robots' => 'nullable|string|max:50',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string',
            'og_image_file' => 'nullable|image|max:5120',
            'structured_data' => 'nullable|string',
        ]);

        // Нормализация пустого slug в null (для главной страницы)
        $data['slug'] = isset($data['slug']) && $data['slug'] !== '' ? $data['slug'] : null;

        // Обработка файла: сохраняем относительный путь в БД (без абсолютного URL)
        if ($request->hasFile('og_image_file')) {
            $path = $request->file('og_image_file')->store('seo', 'public'); // возвращает "seo/....jpg"
            $data['og_image'] = $path;
        } else {
            $data['og_image'] = null;
        }

        // Попытка распарсить JSON-LD в массив (если валидный JSON)
        if (! empty($data['structured_data'])) {
            $decoded = json_decode($data['structured_data'], true);
            $data['structured_data'] = $decoded !== null ? $decoded : null;
        } else {
            $data['structured_data'] = null;
        }

        SeoPage::create($data);

        return redirect()->route('admin.seo-settings.index')->with('success', 'SEO-страница создана');
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
        $page = SeoPage::findOrFail($id);

        return view('admin.seo_pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $page = SeoPage::findOrFail($id);

        $data = $request->validate([
            'slug' => 'nullable|string|max:255|unique:seo_pages,slug,'.$id,
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'keywords' => 'nullable|string|max:255',
            'h1' => 'nullable|string|max:255',
            'canonical' => 'nullable|url|max:1000',
            'robots' => 'nullable|string|max:50',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string',
            'og_image_file' => 'nullable|image|max:5120',
            'structured_data' => 'nullable|string',
            'remove_image' => 'nullable|boolean',
        ]);

        // Нормализуем пустой slug в null
        $data['slug'] = isset($data['slug']) && $data['slug'] !== '' ? $data['slug'] : null;

        // Обработка изображения: только загрузка файла или удаление по флагу.
        if ($request->hasFile('og_image_file')) {
            // удалить старое (если локальное)
            $this->deleteOgImage($page->og_image);

            // сохранить новый и в БД — относительный путь (seo/...)
            $path = $request->file('og_image_file')->store('seo', 'public');
            $data['og_image'] = $path;
        } elseif ($request->boolean('remove_image')) {
            // удалить старое и установить null
            $this->deleteOgImage($page->og_image);
            $data['og_image'] = null;
        } else {
            // не менять поле, если не загружали и не удаляли
            unset($data['og_image']);
        }

        // structured_data -> массив или null
        if (! empty($data['structured_data'])) {
            $decoded = json_decode($data['structured_data'], true);
            $data['structured_data'] = $decoded !== null ? $decoded : null;
        } else {
            $data['structured_data'] = null;
        }

        $page->update($data);

        return redirect()->route('admin.seo-pages.edit', $page->id)->with('success', 'SEO-страница обновлена');
    }

    public function destroy(string $id)
    {
        $page = SeoPage::findOrFail($id);

        // удалить локальное изображение если есть
        $this->deleteOgImage($page->og_image);

        $page->delete();

        return redirect()->route('admin.seo-settings.index')->with('success', 'SEO-страница удалена');
    }

    /**
     * Удаляет файл из public-диска, если URL/путь указывает на /storage/ или на относительный путь.
     */
    private function deleteOgImage(?string $url): void
    {
        if (! $url) {
            return;
        }

        // извлечь путь в storage если в URL есть /storage/
        $path = null;
        $parsed = parse_url($url, PHP_URL_PATH);
        if ($parsed !== null && strpos($parsed, '/storage/') !== false) {
            $path = ltrim(substr($parsed, strpos($parsed, '/storage/') + strlen('/storage/')), '/');
        } elseif (strpos($url, '/storage/') !== false) {
            $path = ltrim(substr($url, strpos($url, '/storage/') + strlen('/storage/')), '/');
        } else {
            // возможно у вас хранится относительный путь (например "seo/xxx.jpg")
            // попробуем использовать значение как относительный путь
            $path = ltrim($url, '/');
        }

        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
