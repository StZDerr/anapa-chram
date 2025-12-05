<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventsCalendarController extends Controller
{
    public function index()
    {
        return view('admin.events.index');
    }
    // Отдаёт JSON для FullCalendar
    public function apiIndex()
    {
        $events = Event::all()->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start,
                'end' => $event->end,
                'color' => $event->color,
            ];
        });

        return response()->json($events);
    }

    // Форма создания нового события
    public function create()
    {
        return view('admin.events.create');
    }

    // Сохраняем событие
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start' => 'required|date',
            'end' => 'nullable|date|after_or_equal:start',
            'color' => 'nullable|string|max:7',
        ]);

        Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Событие добавлено');
    }
}
