<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrthodoxCalendar;

class OrthodoxCalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $calendars = OrthodoxCalendar::all();
        return view('admin.orthodox_calendar.index', compact('calendars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.orthodox_calendar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $data = $request->validate([
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        OrthodoxCalendar::create($data);
        return redirect()->route('admin.orthodox_calendar.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(OrthodoxCalendar $orthodoxCalendar)
    {
       return view('admin.orthodox_calendar.show', compact('orthodoxCalendar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrthodoxCalendar $orthodoxCalendar)
    {
        return view('admin.orthodox_calendar.edit', compact('orthodoxCalendar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrthodoxCalendar $orthodoxCalendar)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $orthodoxCalendar->update($data);
        return redirect()->route('admin.orthodox_calendar.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrthodoxCalendar $orthodoxCalendar)
    {
        $orthodoxCalendar->delete();
        return redirect()->route('admin.orthodox_calendar.index');
    }
}
