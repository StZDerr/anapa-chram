<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrthodoxCalendar;
use Carbon\Carbon;

class OrthodoxCalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create entries for the next 30 days starting from tomorrow
        $start = Carbon::today()->addDay();
        $days = 30;

        for ($i = 0; $i < $days; $i++) {
            $date = $start->copy()->addDays($i);
            $formatted = $date->format('d.m.Y');

            OrthodoxCalendar::create([
                // store date in ISO format (Y-m-d) so DB date columns work correctly
                'date' => $date->toDateString(),
                'title' => "День памяти — {$formatted}",
                'description' => "Память в православном календаре: {$formatted}.",
            ]);
        }

        // Example: add a specific known entry (as in your example)
        $exampleDate = Carbon::createFromFormat('d.m.Y', '13.12.2025');
        if ($exampleDate) {
            OrthodoxCalendar::updateOrCreate(
                ['date' => $exampleDate->toDateString()],
                [
                    'title' => 'День памяти святителя Спиридона Тримифунтского',
                    'description' => 'Память святителя Спиридона, чудотворца и архиепископа Тримифунтского.',
                ]
            );
        }
    }
}
