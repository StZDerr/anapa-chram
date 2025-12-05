<?php

namespace App\Http\Controllers;

use App\Models\Event;

class CalendarController extends Controller
{
    public function index()
    {
        // Получаем все события из БД
        $events = Event::all()->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start ? $event->start->toIso8601String() : null,
                'end' => $event->end ? $event->end->toIso8601String() : null,
                'extendedProps' => [
                    'description' => $event->description,
                ],
                'color' => $event->color ?? '#4a5b6f', // цвет по умолчанию
                'allDay' => false, // всегда показываем время
            ];
        });

        return response()->json($events);
    }
}

