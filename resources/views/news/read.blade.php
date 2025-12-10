<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ $newsItem->title }} - Храм святого князя Владимира в Анапе</title>
    @include('partials.head')

    <!-- Стили страницы News Read -->
    @vite(['resources/css/news-read.css', 'resources/js/news-read.js', 'resources/js/news-swiper.js', 'resources/css/news-swiper.css'])
</head>

<body class="d-flex flex-column min-vh-100">
    @include('partials.navbar')

    <main class="flex-fill">
        <!-- Hero секция с фоном -->
        <div class="news-hero">
            <div class="news-hero-overlay"></div>
            @if ($newsItem->img_preview && Storage::disk('public')->exists($newsItem->img_preview))
                <img src="{{ Storage::url($newsItem->img_preview) }}" alt="{{ $newsItem->title }}" class="news-hero-image">
            @else
                <img src="{{ asset('images/ChramSvitogo.jpg') }}" alt="{{ $newsItem->title }}" class="news-hero-image">
            @endif
            <div class="container">
                <div class="news-hero-content">
                    <div class="news-category">Новости храма</div>
                    <h1 class="news-hero-title">{{ $newsItem->title }}</h1>
                    <div class="news-meta">
                        <span class="news-date">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            {{ $newsItem->published_at ? $newsItem->published_at->format('d.m.Y') : $newsItem->created_at->format('d.m.Y') }}
                        </span>
                        <span class="news-author">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Пресс-служба храма
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Основной контент -->
        <div class="container">
            <div class="news-content">
                <div class="row justify-content-center">
                    <!-- Основной текст на всю ширину -->
                    <div class="col-lg-10 col-xl-9">
                        <article class="news-article">
                            <div class="news-content-display">
                                {!! $newsItem->content !!}
                            </div>
                        </article>
                        <div class="more d-none">
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae vel
                            pariatur, necessitatibus a nostrum at repellendus libero aliquam, obcaecati culpa non iusto.
                            Possimus labore dicta natus suscipit. Sint ab, natus eum asperiores molestiae tempore
                            voluptatem. Placeat voluptatem fugiat incidunt cupiditate officiis labore modi. Eveniet
                            facere expedita libero voluptatem deleniti, beatae quas quae illum fugit error ipsam, qui
                            repellendus, nemo mollitia esse aperiam eligendi. Quidem nam facilis incidunt quasi eveniet
                            quas corporis qui placeat eaque illum aliquid, ut commodi, sint velit repellat eos
                            consequatur facere aut, animi temporibus esse! Adipisci harum sequi facilis omnis
                            repudiandae voluptas dignissimos libero pariatur. Quas labore hic ad quam eaque, ipsum
                            laborum natus deserunt. Dolore debitis ratione autem nisi asperiores tempore placeat in
                            deserunt explicabo dolorem! Unde veritatis, cum ipsum iusto hic et minus itaque nulla
                            incidunt. Inventore perferendis rem soluta voluptatibus quisquam, ipsa doloremque numquam
                            iure. Ipsam architecto sit nihil eum voluptates. Numquam tempore sed nisi consequatur dolore
                            eius voluptates minima quae! Placeat cumque excepturi autem quis laborum distinctio beatae
                            facere, facilis, ducimus aliquid doloribus. Quaerat similique deleniti minus cumque, quasi
                            nostrum sit cupiditate laborum maxime? Ratione inventore amet, repellat suscipit ea et
                            repellendus voluptatum beatae, quaerat possimus eligendi. Voluptate, ipsa. Odio laboriosam
                            impedit quod vero veritatis et aspernatur culpa tempore consequatur? Aliquam laudantium,
                            ducimus doloremque atque nostrum similique veritatis minima dolore laboriosam cumque est
                            itaque sunt. Ullam tempora itaque obcaecati excepturi quasi odit consequatur ducimus sint
                            magni voluptate mollitia placeat, dicta sit assumenda delectus perferendis in doloribus
                            commodi minima eligendi iusto repellendus recusandae. Quisquam debitis deserunt repellat
                            doloribus autem provident tempora reprehenderit soluta deleniti, esse, error, eum ad. Quos
                            deserunt consequuntur quam laborum voluptatibus numquam consequatur! Voluptatem qui libero
                            sit explicabo officia. Impedit atque doloribus, fugit nam officiis exercitationem recusandae
                            odit odio! Eaque harum magni voluptates accusantium architecto recusandae excepturi,
                            temporibus nobis delectus labore enim deleniti praesentium nemo, dolorem doloremque
                            reiciendis repellat laudantium soluta saepe commodi pariatur mollitia esse, fugiat iure!
                            Cumque ducimus dignissimos obcaecati neque saepe totam, ab illo tenetur consectetur delectus
                            dolore quis ipsum eos aliquam dicta ullam, incidunt assumenda voluptates iste molestiae
                            aspernatur maiores fugiat expedita eveniet? In inventore, dignissimos impedit laborum at
                            iste eum provident ratione. Facilis voluptatum quia dolorum animi, laborum quibusdam quidem
                            itaque voluptatibus, sint suscipit ipsum sapiente amet architecto ad mollitia possimus
                            distinctio, maiores provident magnam ducimus. At aperiam minima provident est amet ratione
                            repellendus explicabo id, sed veniam quam optio, qui obcaecati! Officia deserunt ducimus
                            consequuntur. Officia pariatur quisquam natus, harum nulla nostrum provident molestias ipsum
                            temporibus porro. Minima, reiciendis atque! Corrupti, commodi! Ipsum, maiores eius eos
                            molestias nulla ipsa ad illo autem voluptates voluptatibus enim odit a possimus iusto id.
                            Eos dolorem odit numquam molestiae reiciendis ipsam aspernatur eligendi sequi temporibus,
                            facilis sint ea aut nostrum exercitationem doloribus voluptas velit eum quam nemo mollitia
                            porro. Reiciendis, quae aspernatur tempore nobis soluta necessitatibus sunt excepturi
                            consequuntur cupiditate ab sed numquam perspiciatis provident, maiores aut id. Mollitia
                            praesentium dolorum recusandae amet obcaecati quis impedit fugiat necessitatibus error
                            facere architecto dignissimos, sint debitis ipsa accusantium, aliquam, odio incidunt animi!
                            Maxime, praesentium. Aliquid ullam nam, temporibus corporis qui molestiae quam consequatur!
                            Provident quas illo, reiciendis vel nisi animi modi nam? Illo optio eligendi tempora omnis,
                            saepe eos voluptate delectus tenetur nostrum repudiandae, suscipit consequatur iure, odio
                            adipisci officia sunt commodi? Incidunt, reiciendis, at deleniti illo, similique ad totam
                            distinctio placeat voluptate minima doloribus praesentium eum veniam vel consequuntur eaque.
                            Et molestias ullam consequuntur. Ex exercitationem expedita, voluptates eos porro repellat
                            nostrum sed a illo ipsam enim fugit tempora quis asperiores autem? Et, ducimus. Temporibus
                            rerum, praesentium assumenda ipsam quas non blanditiis sit facere itaque aspernatur,
                            deserunt officiis fugit quis.
                        </div>

                        <!-- Фотогалерея -->
                        @if ($newsItem->gallery && count(json_decode($newsItem->gallery, true)) > 0)
                            <div class="news-gallery-section">
                                <h2 class="section-title">Фотогалерея события</h2>
                                <div class="swiper newsGallerySwiper">
                                    <div class="swiper-wrapper">
                                        @foreach (json_decode($newsItem->gallery, true) as $image)
                                            @if (Storage::disk('public')->exists($image))
                                                <div class="swiper-slide">
                                                    <a href="{{ Storage::url($image) }}" data-pswp-width="1200"
                                                        data-pswp-height="800">
                                                        <img src="{{ Storage::url($image) }}"
                                                            alt="Фото {{ $loop->iteration }}">
                                                        <div class="gallery-overlay">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="40"
                                                                height="40" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2">
                                                                <circle cx="11" cy="11" r="8"></circle>
                                                                <line x1="21" y1="21" x2="16.65"
                                                                    y2="16.65"></line>
                                                                <line x1="11" y1="8" x2="11"
                                                                    y2="14"></line>
                                                                <line x1="8" y1="11" x2="14"
                                                                    y2="11"></line>
                                                            </svg>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Другие новости внизу страницы -->
        @include('partials.news-partials')
    </main>

    @include('partials.footer')
    @include('partials.scripts')
</body>

</html>
