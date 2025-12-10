<div class="container">
    <div class="gallery-section">
        <div class="text-center title">КРЕЩЕНСКИЙ ПАРК</div>

        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->

                <div class="swiper-slide active">
                    <img src="{{ asset('images/ChramSvitogo.jpg') }}" alt="Храм святого князя Владимира" />
                    <div class="slide-overlay">
                        <!-- Заголовок с иконкой слева вверху -->
                        <div class="slide-header">
                            <img src="{{ asset('images/Logo2.svg') }}" alt="Логотип" class="slide-icon">
                            <h3 class="slide-title">Крещенский парк</h3>
                        </div>
                        <!-- Описание внизу -->
                        <div class="slide-footer">
                            <p class="slide-description">Горожане с нетерпением ждали долгожданное открытие
                                Крещенского парка в Анапе и уже его посетили, а вот новые жители города не знают,
                                где именно он находится и как сюда можно добраться.</p>
                            <a href="{{ route('temple') }}">
                                <div class="slide-actions">
                                    <span class="slide-link">Узнать больше</span>
                                    <svg class="slide-arrow" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <line x1="5" y1="12" x2="19" y2="12">
                                        </line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="swiper-slide">
                    <img src="{{ asset('images/hram_kupel_knyagini_olgi.jpg') }}" alt="Крещенский парк" />
                    <div class="slide-overlay">
                        <div class="slide-header">
                            <img src="{{ asset('images/Logo2.svg') }}" alt="Логотип" class="slide-icon">
                            <h3 class="slide-title">Крещенский парк</h3>
                        </div>

                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="swiper-slide">
                    <img src="{{ asset('images/derzhavnaya_ikona_bozhej_materi.jpg') }}" alt="Крещенский парк" />
                    <div class="slide-overlay">
                        <div class="slide-header">
                            <img src="{{ asset('images/Logo2.svg') }}" alt="Логотип" class="slide-icon">
                            <h3 class="slide-title">Крещенский парк</h3>
                        </div>

                    </div>
                </div>

                <!-- Slide 4 -->
                <div class="swiper-slide">
                    <img src="{{ asset('images/galery.jpg') }}" alt="Крещенский парк" />
                    <div class="slide-overlay">
                        <div class="slide-header">
                            <img src="{{ asset('images/Logo2.svg') }}" alt="Логотип" class="slide-icon">
                            <h3 class="slide-title">Крещенский парк</h3>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
