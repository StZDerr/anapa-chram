<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>Деятельность храма - Храм святого князя Владимира в Анапе</title>
    @include('partials.head')

    <!-- Стили страницы Activity -->
    @vite(['resources/css/activity.css'])
</head>

<body class="d-flex flex-column min-vh-100">
    @include('partials.navbar')

    <main class="flex-fill">
        <div class="activity-page">
            <div class="container py-5">
                <h1 class="title text-center mb-5">ДЕЯТЕЛЬНОСТЬ ХРАМА</h1>
                <div class="activity-grid">
                    <!-- Карточка 1 -->
                    <div class="activity-card">
                        <div class="activity-card-image">
                            <img src="{{ asset('images/activity.jpg') }}" alt="Приходской хор">
                        </div>
                        <div class="activity-card-overlay">
                            <h3 class="activity-card-title">Приходской хор</h3>
                            <p class="activity-card-description">
                                Профессиональный или любительский коллектив, исполняющий церковное песнопение и
                                создающий музыкальное сопровождение к богослужениям.
                            </p>
                        </div>
                    </div>

                    <!-- Карточка 2 -->
                    <div class="activity-card">
                        <div class="activity-card-image">
                            <img src="{{ asset('images/activity.jpg') }}" alt="Приходской хор">
                        </div>
                        <div class="activity-card-overlay">
                            <h3 class="activity-card-title">Приходской хор</h3>
                            <p class="activity-card-description">
                                Профессиональный или любительский коллектив, исполняющий церковное песнопение и
                                создающий музыкальное сопровождение к богослужениям.
                            </p>
                        </div>
                    </div>

                    <!-- Карточка 3 -->
                    <div class="activity-card">
                        <div class="activity-card-image">
                            <img src="{{ asset('images/activity.jpg') }}" alt="Приходской хор">
                        </div>
                        <div class="activity-card-overlay">
                            <h3 class="activity-card-title">Приходской хор</h3>
                            <p class="activity-card-description">
                                Профессиональный или любительский коллектив, исполняющий церковное песнопение и
                                создающий музыкальное сопровождение к богослужениям.
                            </p>
                        </div>
                    </div>

                    <!-- Карточка 4 -->
                    <div class="activity-card">
                        <div class="activity-card-image">
                            <img src="{{ asset('images/activity.jpg') }}" alt="Приходской хор">
                        </div>
                        <div class="activity-card-overlay">
                            <h3 class="activity-card-title">Приходской хор</h3>
                            <p class="activity-card-description">
                                Профессиональный или любительский коллектив, исполняющий церковное песнопение и
                                создающий музыкальное сопровождение к богослужениям.
                            </p>
                        </div>
                    </div>

                    <!-- Карточка 5 -->
                    <div class="activity-card">
                        <div class="activity-card-image">
                            <img src="{{ asset('images/activity.jpg') }}" alt="Приходской хор">
                        </div>
                        <div class="activity-card-overlay">
                            <h3 class="activity-card-title">Приходской хор</h3>
                            <p class="activity-card-description">
                                Профессиональный или любительский коллектив, исполняющий церковное песнопение и
                                создающий музыкальное сопровождение к богослужениям.
                            </p>
                        </div>
                    </div>

                    <!-- Карточка 6 -->
                    <div class="activity-card">
                        <div class="activity-card-image">
                            <img src="{{ asset('images/activity.jpg') }}" alt="Приходской хор">
                        </div>
                        <div class="activity-card-overlay">
                            <h3 class="activity-card-title">Приходской хор</h3>
                            <p class="activity-card-description">
                                Профессиональный или любительский коллектив, исполняющий церковное песнопение и
                                создающий музыкальное сопровождение к богослужениям.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')

    @include('partials.scripts')
</body>

</html>
