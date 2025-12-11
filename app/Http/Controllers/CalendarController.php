<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    public function index()
    {
        $events = DB::table('events')->get()->map(function ($event) {
            // Явное форматирование с timezone
            $startFormatted = null;
            $endFormatted = null;

            if ($event->start) {
                $startFormatted = date('Y-m-d\TH:i:sP', strtotime($event->start.' Europe/Moscow'));
            }

            if ($event->end) {
                $endFormatted = date('Y-m-d\TH:i:sP', strtotime($event->end.' Europe/Moscow'));
            }

            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $startFormatted,
                'end' => $endFormatted,
                'extendedProps' => [
                    'description' => $event->description,
                ],
                'color' => $event->color ?? '#4a5b6f',
                'allDay' => false,
            ];
        });

        return response()->json($events);
    }
}
