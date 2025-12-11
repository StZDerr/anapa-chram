<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventsTableSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $firstDay = Carbon::create($year, $month, 1)->startOfDay();
        $lastDay = Carbon::create($year, $month, 1)->endOfMonth()->endOfDay();
        $daysInMonth = $lastDay->day;

        $description = trim(<<<'TXT'
Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.

(копировать при необходимости - текст из вашего примера)
TXT
        );

        // Удалим старые записи этого заголовка в текущем месяце, чтобы не дублировать при повторном запуске
        DB::table('events')
            ->where('title', 'Глубокое дыхание')
            ->whereBetween('start', [$firstDay->toDateTimeString(), $lastDay->toDateTimeString()])
            ->delete();

        $nowTimestamp = Carbon::now()->toDateTimeString();

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $start = Carbon::create($year, $month, $day, 17, 40, 0)->toDateTimeString();

            DB::table('events')->insert([
                'title' => 'Глубокое дыхание',
                'description' => $description,
                'start' => $start,
                'end' => null,
                'color' => '#378006',
                'created_at' => $nowTimestamp,
                'updated_at' => $nowTimestamp,
            ]);
        }
    }
}
