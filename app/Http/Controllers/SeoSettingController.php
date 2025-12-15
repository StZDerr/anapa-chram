<?php

namespace App\Http\Controllers;

use App\Models\SeoPage;
use App\Models\SeoSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeoSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = SeoSetting::first();
        $pages = SeoPage::orderBy('slug')->get();
        $site_settings = DB::table('site_settings')->first();

        return view('admin.seo_settings.index', compact('setting', 'pages', 'site_settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SeoSetting $seoSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SeoSetting $seoSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SeoSetting $seoSetting)
    {
        $data = $request->validate([
            'global_indexing' => 'nullable|boolean',
        ]);

        $seoSetting->global_indexing = $request->boolean('global_indexing');
        $seoSetting->save();

        return redirect()->route('admin.seo-settings.index')->with('success', 'Настройки SEO обновлены');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SeoSetting $seoSetting)
    {
        //
    }
}
