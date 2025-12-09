<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Event;
use App\Models\News;
use App\Models\OrthodoxCalendar;
use Carbon\Carbon;

class PageController extends Controller
{
    // Главная страница
    public function welcome()
    {
        $today = Carbon::today();

        // диапазон для маленького календаря (3 дня до / 3 дня после)
        $start = $today->copy()->subDays(3)->startOfDay(); // 3 дня до, начало дня
        $end = $today->copy()->addDays(3)->endOfDay();   // 3 дня после, конец дня

        $orthodoxCalendars = OrthodoxCalendar::whereBetween('date', [$start, $end])
            ->orderBy('date')
            ->get();

        // диапазон текущей недели (понедельник - воскресенье) для расписания
        $startOfWeek = $today->copy()->startOfWeek(Carbon::MONDAY)->startOfDay();
        $endOfWeek = $today->copy()->endOfWeek(Carbon::SUNDAY)->endOfDay();

        // события недели
        $weekEvents = Event::whereBetween('start', [$startOfWeek, $endOfWeek])
            ->orderBy('start')
            ->get();

        $news = News::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->get();

        $activitys = Activity::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->get();

        return view('welcome', compact('orthodoxCalendars', 'weekEvents', 'today', 'start', 'end', 'startOfWeek', 'endOfWeek', 'news', 'activitys'));
    }

    // Страница календаря
    public function calendar()
    {
        $today = Carbon::today();

        $start = $today->copy()->subDays(3)->startOfDay(); // 3 дня до, начало дня
        $end = $today->copy()->addDays(3)->endOfDay();   // 3 дня после, конец дня

        $orthodoxCalendars = OrthodoxCalendar::whereBetween('date', [$start, $end])
            ->orderBy('date')
            ->get();

        return view('calendar', compact('orthodoxCalendars', 'today', 'start', 'end'));
    }

    public function news()
    {
        $news = News::where('status', 'published')
            ->orderBy('created_at', 'desc')->get();

        return view('news.index', compact('news')); // view resources/views/news/index.blade.php
    }

    public function newsRead($slug)
    {
        $news = News::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $otherNews = News::where('status', 'published')
            ->where('id', '!=', $news->id)
            ->orderBy('published_at', 'desc')
            ->take(6)
            ->get();

        return view('news.read', compact('news', 'otherNews'));
    }

    public function activity()
    {
        $activities = Activity::where('status', 'published')
            ->orderBy('created_at', 'desc')->get();

        return view('activity.index', compact('activities')); // view resources/views/activity/index.blade.php
    }

    public function activityRead($slug)
    {
        $activity = Activity::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $otherActivity = Activity::where('status', 'published')
            ->where('id', '!=', $activity->id)
            ->orderBy('published_at', 'desc')
            ->take(6)
            ->get();

        return view('activity.read', compact('activity', 'otherActivity'));
    }
}
