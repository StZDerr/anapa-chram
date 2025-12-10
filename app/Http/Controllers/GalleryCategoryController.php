<?php

namespace App\Http\Controllers;

use App\Models\PhotoCategory;
use Illuminate\Http\Request;

class GalleryCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = PhotoCategory::withCount('photos')->orderBy('name')->get();

        return view('admin.gallery.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.gallery.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        PhotoCategory::create([
            'name' => $data['name'],
        ]);

        return redirect()->route('admin.gallery.categories.index')->with('success', 'Категория создана.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PhotoCategory $photoCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PhotoCategory $photoCategory)
    {
        return view('admin.gallery.category.edit', compact('photoCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PhotoCategory $gallery_category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $gallery_category->update([
            'name' => $data['name'],
        ]);

        return redirect()->route('admin.gallery.categories.index')->with('success', 'Категория обновлена.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PhotoCategory $gallery_category)
    {
        $gallery_category->delete();

        return redirect()->route('admin.gallery.categories.index')->with('success', 'Категория удалена.');
    }
}
