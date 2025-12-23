<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Attraction;
use App\Models\Clergy;
use App\Models\ContentBlock;
use App\Models\Event;
use App\Models\News;
use App\Models\OrthodoxCalendar;
use App\Models\ParkRule;
use App\Models\Photo;
use App\Models\PhotoCategory;
use App\Models\TempleConstruction;
use App\Models\TemplePage;
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

        $categories = $this->loadCategoriesWithLimit(5);

        return view('welcome', compact('orthodoxCalendars', 'weekEvents', 'today', 'start', 'end', 'startOfWeek', 'endOfWeek', 'news', 'activitys', 'categories'));
    }

    /**
     * Загружает все категории и в каждой категории максимум $limit фото (по убыванию created_at).
     * Реализовано простым запросом фотографий для каждой категории (N+1 запросов для photos,
     * но обычно число категорий невелико — это простое и надёжное решение).
     *
     * @return \Illuminate\Database\Eloquent\Collection|PhotoCategory[]
     */
    private function loadCategoriesWithLimit(int $limit = 5)
    {
        $categories = PhotoCategory::orderBy('name')->get();

        foreach ($categories as $category) {
            $category->setRelation(
                'photos',
                $category->photos()
                    ->orderBy('created_at', 'desc')
                    ->take($limit)
                    ->get()
            );
        }

        return $categories;
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
        $newsItem = News::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $news = News::where('status', 'published')
            ->where('id', '!=', $newsItem->id)
            ->orderBy('published_at', 'desc')
            ->take(6)
            ->get();

        return view('news.read', compact('newsItem', 'news'));
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

        $activitys = Activity::where('status', 'published')
            ->where('id', '!=', $activity->id)
            ->orderBy('published_at', 'desc')
            ->take(6)
            ->get();

        // Подготовка данных расписания (для timetable-partials)
        $today = Carbon::today();
        $startOfWeek = $today->copy()->startOfWeek(Carbon::MONDAY)->startOfDay();
        $endOfWeek = $today->copy()->endOfWeek(Carbon::SUNDAY)->endOfDay();

        $weekEvents = Event::whereBetween('start', [$startOfWeek, $endOfWeek])
            ->orderBy('start')
            ->get();

        return view('activity.read', compact('activity', 'activitys', 'weekEvents', 'today', 'startOfWeek', 'endOfWeek'));
    }

    public function temple()
    {
        $templePage = TemplePage::getByKey('temple_main');
        $activitys = Activity::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->get();

        $categories = $this->loadCategoriesWithLimit(5);

        $clergy = Clergy::orderBy('order')->get();

        return view('temple', compact('templePage', 'activitys', 'categories', 'clergy'));
    }

    public function kupelOlgi()
    {
        $templePage = TemplePage::getByKey('kupel-olgi');
        $activitys = Activity::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->get();

        $categories = $this->loadCategoriesWithLimit(5);

        $clergy = Clergy::orderBy('order')->get();

        return view('temple', compact('templePage', 'activitys', 'categories', 'clergy'));
    }

    public function derzhavnayaIkona()
    {
        $templePage = TemplePage::getByKey('derzhavnaya-ikona');
        $activitys = Activity::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->get();

        $categories = $this->loadCategoriesWithLimit(5);

        $clergy = Clergy::orderBy('order')->get();

        return view('temple', compact('templePage', 'activitys', 'categories', 'clergy'));
    }

    public function gallery()
    {
        // Подгружаем категории с их фотографиями (последние сверху)
        $categories = $this->loadCategoriesWithLimit(5);

        // Все фото (для вкладки "Все")
        $allPhotos = Photo::with('category')->orderBy('created_at', 'desc')->get();

        return view('gallery.index', compact('categories', 'allPhotos'));
    }

    public function clergy()
    {
        $clergy = Clergy::orderBy('order')->get();

        return view('clergy', compact('clergy'));
    }

    public function park()
    {
        $attractions = Attraction::orderBy('order')->get();
        $construction = TempleConstruction::with('images')->first();
        $parkRule = ParkRule::first();

        return view('park', compact('attractions', 'construction', 'parkRule'));
    }

    public function treby()
    {
        $blocks = ContentBlock::with('images')->get();

        return view('zapiskiAndTreby/treby', compact('blocks'));
    }

    public function trebyShow(string $slug)
    {
        // Ищем сначала по slug, затем — по id (позволяет работать пока не у всех есть slug)
        $block = ContentBlock::where('slug', $slug)
            ->orWhere('id', $slug)
            ->firstOrFail();

        return view('zapiskiAndTreby.treby-show', compact('block'));
    }
}
