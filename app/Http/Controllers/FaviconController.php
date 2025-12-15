<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FaviconController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'favicon' => 'required|file|mimes:ico,png,svg,svg+xml|mimetypes:image/x-icon,image/vnd.microsoft.icon,image/png,image/svg+xml|max:2048',
        ]);

        $file = $request->file('favicon');
        $path = $file->store('favicons', 'public');

        $setting = DB::table('site_settings')->first();

        // Удалить предыдущий файл, если есть
        if ($setting && ! empty($setting->favicon)) {
            Storage::disk('public')->delete($setting->favicon);
        }

        if ($setting) {
            DB::table('site_settings')->where('id', $setting->id)->update([
                'favicon' => $path,
                'updated_at' => now(),
            ]);
        } else {
            DB::table('site_settings')->insert([
                'favicon' => $path,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('admin.seo-settings.index')->with('success', 'Фавикон сохранён.');
    }
}
