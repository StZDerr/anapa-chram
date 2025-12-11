<div class="container pb-3 pt-3">
    @if (request()->routeIs('welcome'))
        <div class="text-center quick-title">Быстрый доступ</div>
    @else
        <h1 class="text-center quick-title m-4">О ХРАМЕ</h1>
    @endif

    <div class="quick">
        <div class="div2">
            <a href="{{ route('temple') }}">
                <div class="quick-card height-fix">
                    <img src="{{ asset('images/ChramSvitogo.jpg') }}" alt="Храм святого князя Владимира">
                    <div class="quick-card-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                    <div class="quick-card-content">
                        <h3 class="quick-card-title">Храм святого<br>князя Владимира
                        </h3>
                    </div>
                </div>
            </a>
        </div>
        <div class="div3">
            <a href="{{ route('temple.kupelOlgi') }}">
                <div class="quick-card">
                    <img src="{{ asset('images/hram_kupel_knyagini_olgi.jpg') }}" alt="Храм-купель княгини Ольги">
                    <div class="quick-card-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                    <div class="quick-card-content">
                        <h3 class="quick-card-title">Храм-купель<br>княгини Ольги</h3>
                    </div>
                </div>
            </a>
        </div>
        <div class="div4">
            <a href="{{ route('temple.derzhavnayaIkona') }}">
                <div class="quick-card height-fix">
                    <img src="{{ asset('images/derzhavnaya_ikona_bozhej_materi.jpg') }}"
                        alt="Державная икона Божьей матери">
                    <div class="quick-card-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                    <div class="quick-card-content">
                        <h3 class="quick-card-title">Державная икона<br>Божьей матери
                        </h3>
                    </div>
                </div>
            </a>
        </div>
        <div class="div5">
            <a href="{{ route('gallery') }}">
                <div class="quick-card">
                    <img src="{{ asset('images/galery.jpg') }}" alt="Галерея">
                    <div class="quick-card-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                    <div class="quick-card-content">
                        <h3 class="quick-card-title">Галерея</h3>
                    </div>
                </div>
            </a>
        </div>
        <div class="div6">
            <a href="{{ route('clergy') }}">
                <div class="quick-card height-fix">
                    <img src="{{ asset('images/Duhovenstvo.jpg') }}" alt="Духовенство">
                    <div class="quick-card-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                    <div class="quick-card-content">
                        <h3 class="quick-card-title">Духовенство</h3>
                    </div>
                </div>
            </a>
        </div>
        <div class="div7">
            <a href="">
                <div class="quick-card">
                    <img src="{{ asset('images/Popechiteli.jpg') }}" alt="Попечители">
                    <div class="quick-card-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                    <div class="quick-card-content">
                        <h3 class="quick-card-title">Попечители</h3>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
