<div class="container mb-5">
    <div class="photo-section">

        <div class="text-center title">ФОТОГАЛЕРЕЯ</div>
        <!-- Фильтры категорий -->
        <div class="photo-filters d-flex justify-content-center gap-3 mb-4">
            <button class="btn btn-filter active" data-target="#gallery-temple">Храм</button>
            <button class="btn btn-filter" data-target="#gallery-festivals">Праздники</button>
            <button class="btn btn-filter" data-target="#gallery-park">Крещенский парк</button>
        </div>

        <!-- Галереи: по одному Swiper на категорию -->
        <div class="gallery-wrap">
            <!-- Храм -->
            <div id="gallery-temple" class="gallery-instance">
                <!-- Кнопки навигации для Храм -->
                <div class="swiper-button-prev gallery-temple-prev">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </div>
                <div class="swiper-button-next gallery-temple-next">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </div>
                <div class="swiper gallery-swiper gallery-temple-swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><a href="{{ asset('images/ChramSvitogo.jpg') }}"
                                data-pswp-width="1200" data-pswp-height="800">
                                <img src="{{ asset('images/ChramSvitogo.jpg') }}" alt="Храм">
                            </a>
                        </div>
                        <div class="swiper-slide"><a href="{{ asset('images/galery.jpg') }}" data-pswp-width="1200"
                                data-pswp-height="800">
                                <img src="{{ asset('images/galery.jpg') }}" alt="Интерьер">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="{{ asset('images/Duhovenstvo.jpg') }}" data-pswp-width="1200"
                                data-pswp-height="800">
                                <img src="{{ asset('images/Duhovenstvo.jpg') }}" alt="Духовенство">
                            </a>
                        </div>
                        <div class="swiper-slide"><a href="{{ asset('images/Popechiteli.jpg') }}" data-pswp-width="1200"
                                data-pswp-height="800">
                                <img src="{{ asset('images/Popechiteli.jpg') }}" alt="Храм 4">
                            </a>
                        </div>
                        <div class="swiper-slide"><a href="{{ asset('images/hram_kupel_knyagini_olgi.jpg') }}"
                                data-pswp-width="1200" data-pswp-height="800">
                                <img src="{{ asset('images/hram_kupel_knyagini_olgi.jpg') }}" alt="Купель">
                            </a>
                        </div>
                        <div class="swiper-slide"><a href="{{ asset('images/derzhavnaya_ikona_bozhej_materi.jpg') }}"
                                data-pswp-width="1200" data-pswp-height="800">
                                <img src="{{ asset('images/derzhavnaya_ikona_bozhej_materi.jpg') }}" alt="Икона">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Праздники -->
            <div id="gallery-festivals" class="gallery-instance d-none">
                <!-- Кнопки навигации для Праздники -->
                <div class="swiper-button-prev gallery-festivals-prev">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </div>
                <div class="swiper-button-next gallery-festivals-next">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </div>
                <div class="swiper gallery-swiper gallery-festivals-swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><a href="{{ asset('images/newsOne.jpg') }}" data-pswp-width="1200"
                                data-pswp-height="800">
                                <img src="{{ asset('images/newsOne.jpg') }}" alt="Праздник">
                            </a>
                        </div>
                        <div class="swiper-slide"><a href="{{ asset('images/activity.jpg') }}" data-pswp-width="1200"
                                data-pswp-height="800">
                                <img src="{{ asset('images/activity.jpg') }}" alt="Праздник 2">
                            </a>
                        </div>
                        <div class="swiper-slide"><a href="{{ asset('images/newsOne.jpg') }}" data-pswp-width="1200"
                                data-pswp-height="800">
                                <img src="{{ asset('images/newsOne.jpg') }}" alt="Праздник 3">
                            </a>
                        </div>
                        <div class="swiper-slide"><a href="{{ asset('images/activity.jpg') }}"
                                data-pswp-width="1200" data-pswp-height="800">
                                <img src="{{ asset('images/activity.jpg') }}" alt="Праздник 4">
                            </a>
                        </div>
                        <div class="swiper-slide"><a href="{{ asset('images/newsOne.jpg') }}" data-pswp-width="1200"
                                data-pswp-height="800">
                                <img src="{{ asset('images/newsOne.jpg') }}" alt="Праздник 5">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Крещенский парк -->
            <div id="gallery-park" class="gallery-instance d-none">
                <!-- Кнопки навигации для Парк -->
                <div class="swiper-button-prev gallery-park-prev">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </div>
                <div class="swiper-button-next gallery-park-next">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </div>
                <div class="swiper gallery-swiper gallery-park-swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><a href="{{ asset('images/ChramSvitogo.jpg') }}"
                                data-pswp-width="1200" data-pswp-height="800"><img
                                    src="{{ asset('images/ChramSvitogo.jpg') }}" alt="Парк"></a></div>
                        <div class="swiper-slide"><a href="{{ asset('images/galery.jpg') }}" data-pswp-width="1200"
                                data-pswp-height="800"><img src="{{ asset('images/galery.jpg') }}"
                                    alt="Парк 2"></a></div>
                        <div class="swiper-slide"><a href="{{ asset('images/Duhovenstvo.jpg') }}"
                                data-pswp-width="1200" data-pswp-height="800"><img
                                    src="{{ asset('images/Duhovenstvo.jpg') }}" alt="Парк 3"></a></div>
                        <div class="swiper-slide"><a href="{{ asset('images/Popechiteli.jpg') }}"
                                data-pswp-width="1200" data-pswp-height="800"><img
                                    src="{{ asset('images/Popechiteli.jpg') }}" alt="Парк 4"></a></div>
                        <div class="swiper-slide"><a href="{{ asset('images/hram_kupel_knyagini_olgi.jpg') }}"
                                data-pswp-width="1200" data-pswp-height="800"><img
                                    src="{{ asset('images/hram_kupel_knyagini_olgi.jpg') }}" alt="Парк 5"></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
