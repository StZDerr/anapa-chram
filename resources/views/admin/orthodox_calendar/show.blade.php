@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('components.alerts')
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Просмотр записи календаря</h5>
                        <div>
                            <a href="{{ route('admin.orthodox_calendar.edit', $orthodoxCalendar->id) }}"
                                class="btn btn-sm btn-outline-secondary">Редактировать</a>
                            <a href="{{ route('admin.orthodox_calendar.index') }}"
                                class="btn btn-sm btn-outline-secondary">Назад</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-3">ID</dt>
                            <dd class="col-sm-9">{{ $orthodoxCalendar->id }}</dd>

                            <dt class="col-sm-3">Дата</dt>
                            <dd class="col-sm-9">{{ $orthodoxCalendar->date }}</dd>

                            <dt class="col-sm-3">Заголовок</dt>
                            <dd class="col-sm-9">{{ $orthodoxCalendar->title }}</dd>

                            <dt class="col-sm-3">Описание</dt>
                            <dd class="col-sm-9">{!! nl2br(e($orthodoxCalendar->description)) !!}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
