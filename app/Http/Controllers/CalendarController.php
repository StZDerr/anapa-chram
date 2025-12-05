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
                'start' => $event->start,
                'end' => $event->end,
                'description' => $event->description,
                'color' => $event->color ?? '#4a5b6f', // цвет по умолчанию
                'allDay' => empty($event->end), // если нет времени окончания, считаем весь день
            ];
        });

        return response()->json($events);
    }
}

