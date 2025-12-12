<?php

namespace App\Http\Controllers;

use App\Models\ParkRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ParkRuleController extends Controller
{
    public function index()
    {
        $parkRule = ParkRule::first();

        return view('admin.ParkRules.index', compact('parkRule'));
    }

    public function create()
    {
        if (ParkRule::exists()) {
            return redirect()->route('admin.park-rules.index')
                ->with('error', 'Запись уже существует.');
        }

        return view('admin.ParkRules.create');
    }

    public function store(Request $request)
    {
        if (ParkRule::exists()) {
            return redirect()->route('admin.park-rules.index')
                ->with('error', 'Запись уже существует.');
        }

        $validated = $request->validate([
            'allowed_title' => 'required|string|max:255',
            'allowed_subtitle' => 'nullable|string|max:255',
            'prohibited_title' => 'required|string|max:255',
            'prohibited_subtitle' => 'nullable|string|max:255',
        ]);

        $validated['items'] = [];

        $parkRule = ParkRule::create($validated);

        return redirect()->route('admin.park-rules.edit', $parkRule)
            ->with('success', 'Запись создана. Добавьте правила и запреты.');
    }

    public function edit(ParkRule $parkRule)
    {
        return view('admin.ParkRules.edit', compact('parkRule'));
    }

    public function update(Request $request, ParkRule $parkRule)
    {
        $validated = $request->validate([
            'allowed_title' => 'required|string|max:255',
            'allowed_subtitle' => 'nullable|string|max:255',
            'prohibited_title' => 'required|string|max:255',
            'prohibited_subtitle' => 'nullable|string|max:255',
        ]);

        $parkRule->update($validated);

        return redirect()->route('admin.park-rules.edit', $parkRule)
            ->with('success', 'Запись обновлена.');
    }

    public function destroy(ParkRule $parkRule)
    {
        // Удаляем все SVG файлы
        foreach ($parkRule->items ?? [] as $item) {
            if (! empty($item['svg']) && Storage::disk('public')->exists($item['svg'])) {
                Storage::disk('public')->delete($item['svg']);
            }
        }

        $parkRule->delete();

        return redirect()->route('admin.park-rules.index')
            ->with('success', 'Запись удалена.');
    }

    /**
     * Добавить новый пункт (правило или запрет)
     */
    public function addItem(Request $request, ParkRule $parkRule)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'category' => 'required|in:allowed,prohibited',
            'svg' => 'nullable|file|mimes:svg,png,jpg,jpeg|max:2048',
        ]);

        $items = $parkRule->items ?? [];

        $newItem = [
            'id' => (string) Str::uuid(),
            'title' => $validated['title'],
            'category' => $validated['category'],
            'svg' => null,
            'order' => count($items),
        ];

        if ($request->hasFile('svg')) {
            $newItem['svg'] = $request->file('svg')->store('park-rules', 'public');
        }

        $items[] = $newItem;
        $parkRule->update(['items' => $items]);

        return redirect()->route('admin.park-rules.edit', $parkRule)
            ->with('success', 'Пункт добавлен.');
    }

    /**
     * Обновить пункт
     */
    public function updateItem(Request $request, ParkRule $parkRule, $itemId)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'svg' => 'nullable|file|mimes:svg,png,jpg,jpeg|max:2048',
            'remove_svg' => 'nullable|boolean',
        ]);

        $items = $parkRule->items ?? [];

        $pos = collect($items)->search(fn ($it) => isset($it['id']) && $it['id'] === $itemId);
        if ($pos === false) {
            return response()->json(['error' => 'Пункт не найден'], 404);
        }

        $items[$pos]['title'] = $validated['title'];

        if ($request->boolean('remove_svg') && ! empty($items[$pos]['svg'])) {
            if (Storage::disk('public')->exists($items[$pos]['svg'])) {
                Storage::disk('public')->delete($items[$pos]['svg']);
            }
            $items[$pos]['svg'] = null;
        }

        if ($request->hasFile('svg')) {
            if (! empty($items[$pos]['svg']) && Storage::disk('public')->exists($items[$pos]['svg'])) {
                Storage::disk('public')->delete($items[$pos]['svg']);
            }
            $items[$pos]['svg'] = $request->file('svg')->store('park-rules', 'public');
        }

        $parkRule->update(['items' => $items]);

        return response()->json(['success' => true]);
    }

    /**
     * Удалить пункт
     */
    public function deleteItem(ParkRule $parkRule, $itemId)
    {
        $items = $parkRule->items ?? [];

        $pos = collect($items)->search(fn ($it) => isset($it['id']) && $it['id'] === $itemId);
        if ($pos === false) {
            return response()->json(['error' => 'Пункт не найден'], 404);
        }

        if (! empty($items[$pos]['svg']) && Storage::disk('public')->exists($items[$pos]['svg'])) {
            Storage::disk('public')->delete($items[$pos]['svg']);
        }

        array_splice($items, $pos, 1);

        // Обновим order у оставшихся элементов (опционально)
        foreach ($items as $i => &$it) {
            $it['order'] = $i;
        }

        $parkRule->update(['items' => $items]);

        return response()->json(['success' => true]);
    }
}
