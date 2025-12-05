@extends('layouts.app')

@section('content')
    @vite(['resources/css/calendar.css'])
    <main class="flex-fill">
        <div class="container calendar-container">
            <h1 class="calendar-title">ЕЖЕДНЕВНОЕ РАСПИСАНИЕ</h1>
            <a href="{{ route('admin.events.create') }}" class="btn btn-success mb-3">Добавить мероприятие</a>

            <!-- Селекторы месяца и года -->
            <div class="calendar-controls">
                <select id="month-select" class="month-select">
                    <option value="0">январь</option>
                    <option value="1">февраль</option>
                    <option value="2">март</option>
                    <option value="3">апрель</option>
                    <option value="4">май</option>
                    <option value="5">июнь</option>
                    <option value="6">июль</option>
                    <option value="7">август</option>
                    <option value="8">сентябрь</option>
                    <option value="9">октябрь</option>
                    <option value="10">ноябрь</option>
                    <option value="11">декабрь</option>
                </select>
                <select id="year-select" class="year-select">
                    <!-- Заполняется динамически через JS -->
                </select>
            </div>

            <div id="calendar"></div>
        </div>
    </main>
@endsection

@push('scripts')
    @vite(['resources/js/calendar.js'])

    <script>
        // Переопределяем URL для админки
        window.CALENDAR_EVENTS_URL = '/admin/api/events';
    </script>
@endpush
