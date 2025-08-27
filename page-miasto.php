<?php
/*
Template Name: Strona Miasta
*/
get_header(); 
?>

<main class="main-content">
    <div class="photo-gallery">
        <div class="photo-frame">
            <video
                src="<?php echo get_template_directory_uri(); ?>/videos/film1.mp4"
                alt="Event video 1"
                autoplay
                muted
                loop
                playsinline
                data-start-time="7"
                onerror="this.outerHTML='<img src=\'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjgwIiBoZWlnaHQ9IjMyMCIgdmlld0JveD0iMCAwIDI4MCAzMjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIyODAiIGhlaWdodD0iMzIwIiBmaWxsPSIjRjBGMEYwIi8+Cjx0ZXh0IHg9IjE0MCIgeT0iMTY1IiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmaWxsPSIjOTk5IiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTQiPkV2ZW50IFZpZGVvIDE8L3RleHQ+Cjwvc3ZnPg==\' alt=\'Event Video 1\'/>'"
            ></video>
        </div>

        <div class="photo-frame">
            <video
                src="<?php echo get_template_directory_uri(); ?>/videos/film2.mp4"
                alt="Event video 2"
                autoplay
                muted
                loop
                playsinline
                data-start-time="3"
                onerror="this.outerHTML='<img src=\'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjgwIiBoZWlnaHQ9IjMyMCIgdmlld0JveD0iMCAwIDI4MCAzMjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIyODAiIGhlaWdodD0iMzIwIiBmaWxsPSIjRjBGMEYwIi8+Cjx0ZXh0IHg9IjE0MCIgeT0iMTY1IiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmaWxsPSIjOTk5IiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTQiPkV2ZW50IFZpZGVvIDI8L3RleHQ+Cjwvc3ZnPg==\' alt=\'Event Video 2\'/>'"
            ></video>
        </div>

        <div class="photo-frame">
            <video
                src="<?php echo get_template_directory_uri(); ?>/videos/film1.mp4"
                alt="Event video 3"
                autoplay
                muted
                loop
                playsinline
                data-start-time="2"
                onerror="this.outerHTML='<img src=\'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjgwIiBoZWlnaHQ9IjMyMCIgdmlld0JveD0iMCAwIDI4MCAzMjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDA0L3N2ZyI+CjxyZWN0IHdpZHRoPSIyODAiIGhlaWdodD0iMzIwIiBmaWxsPSIjRjBGMEYwIi8+Cjx0ZXh0IHg9IjE0MCIgeT0iMTY1IiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmaWxsPSIjOTk5IiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTQiPkV2ZW50IFZpZGVvIDM8L3RleHQ+Cjwvc3ZnPg==\' alt=\'Event Video 3\'/>'"
            ></video>
        </div>

        <div class="photo-frame">
            <video
                src="<?php echo get_template_directory_uri(); ?>/videos/film2.mp4"
                alt="Event video 4"
                autoplay
                muted
                loop
                playsinline
                data-start-time="4"
                onerror="this.outerHTML='<img src=\'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjgwIiBoZWlnaHQ9IjMyMCIgdmlld0JveD0iMCAwIDI4MCAzMjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIyODAiIGhlaWdodD0iMzIwIiBmaWxsPSIjRjBGMEYwIi8+Cjx0ZXh0IHg9IjE0MCIgeT0iMTY1IiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmaWxsPSIjOTk5IiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTQiPkV2ZW50IFZpZGVvIDQ8L3RleHQ+Cjwvc3ZnPg==\' alt=\'Event Video 4\'/>'"
            ></video>
        </div>
    </div>
</main>

<!-- Welcome Section z edytowalną nazwą miasta -->
<section id="welcome" class="welcome-section">
    <div class="container-fluid px-0">
        <div
            class="welcome-header text-center py-5"
            style="background: rgba(255, 255, 255, 0.9)"
        >
            <h2 class="mb-3">
                Witamy w
                <span style="color: #801039; font-weight: bold">
                    Fotobudka <?php echo get_acf_value('nazwa_miasta', get_the_title()); ?>!
                </span>
            </h2>
            <p class="lead" style="color: #666">
                <?php 
                $miasto_opis = get_acf_value('miasto_opis', '');
                if ($miasto_opis) {
                    echo $miasto_opis;
                } else {
                    echo 'Dopełniamy, by na Twoim wydarzeniu nie zabrakło Atrakcji!';
                }
                ?>
            </p>
        </div>

        <div
            class="offers-section py-5"
            style="
                background: linear-gradient(
                    135deg,
                    #f8f9fa 0%,
                    #e9ecef 100%
                );
            "
        >
            <div class="container">
                <h3 class="text-center mb-5" style="color: #2c2c2c">
                    Nasza <span style="color: #801039">oferta</span> w <?php echo get_acf_value('nazwa_miasta', get_the_title()); ?>
                </h3>

                <div class="row g-4">
                    <!-- Fotobudka 360 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="offer-card offer-card-360 h-100">
                            <div class="card-background"></div>
                            <div class="card-overlay"></div>
                            <div class="card-content">
                                <h4>Fotobudka 360</h4>
                                <p>
                                    <?php echo get_acf_value('oferta_360_opis', 'Wejdź do centrum uwagi z naszą obrotową fotobudką 360°! Twórz spektakularne, dynamiczne filmy w zwolnionym tempie. Idealne na wesela, imprezy firmowe i urodziny. Gwarantujemy niezapomniane wspomnienia i mnóstwo zabawy dla wszystkich gości.'); ?>
                                </p>
                            </div>
                            <div class="card-title-overlay">
                                <h4>Fotobudka 360</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Fotolustro -->
                    <div class="col-lg-4 col-md-6">
                        <div class="offer-card offer-card-mirror h-100">
                            <div class="card-background"></div>
                            <div class="card-overlay"></div>
                            <div class="card-content">
                                <h4>Fotolustro</h4>
                                <p>
                                    <?php echo get_acf_value('oferta_mirror_opis', 'Magiczne lustro, które robi zdjęcia! Interaktywne fotolustro z animacjami i zabawnymi dodatkami. Goście mogą pozować, robić selfie i od razu drukować pamiątkowe zdjęcia. Doskonałe na każdą okazję - od eleganckich eventów po szalone imprezy.'); ?>
                                </p>
                            </div>
                            <div class="card-title-overlay">
                                <h4>Fotolustro</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Ciężki dym -->
                    <div class="col-lg-4 col-md-6">
                        <div class="offer-card offer-card-smoke h-100">
                            <div class="card-background"></div>
                            <div class="card-overlay"></div>
                            <div class="card-content">
                                <h4>Ciężki dym</h4>
                                <p>
                                    <?php echo get_acf_value('oferta_smoke_opis', 'Stwórz bajkową atmosferę z naszym efektem ciężkiego dymu! Gęsta, biała mgła unosi się przy ziemi, tworząc magiczny klimat podczas pierwszego tańca, wejścia pary młodej czy kluczowych momentów imprezy. Całkowicie bezpieczny i spektakularny.'); ?>
                                </p>
                            </div>
                            <div class="card-title-overlay">
                                <h4>Ciężki dym</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Fontanny iskier -->
                    <div class="col-lg-4 col-md-6 offset-lg-2">
                        <div class="offer-card offer-card-fountain h-100">
                            <div class="card-background"></div>
                            <div class="card-overlay"></div>
                            <div class="card-content">
                                <h4>Fontanny iskier</h4>
                                <p>
                                    <?php echo get_acf_value('oferta_fountain_opis', 'Wybuchaj radością z naszymi fontannami iskier! Zimne ognie tworzą oszałamiające efekty świetlne bez zagrożenia. Idealne na tort weselny, pierwsze wejście czy kulminacyjne momenty imprezy. Bezpieczne, efektowne i niezapomniane dla wszystkich gości.'); ?>
                                </p>
                            </div>
                            <div class="card-title-overlay">
                                <h4>Fontanny iskier</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Neonowe napisy -->
                    <div class="col-lg-4 col-md-6">
                        <div class="offer-card offer-card-neons h-100">
                            <div class="card-background"></div>
                            <div class="card-overlay"></div>
                            <div class="card-content">
                                <h4>Neonowe napisy</h4>
                                <p>
                                    <?php echo get_acf_value('oferta_neons_opis', 'Świeć jaśniej niż gwiazdy z naszymi neonowymi napisami LED! Personalizowane napisy z imionami, datami lub hasłami. Kolorowe podświetlenie tworzy niesamowity klimat i doskonałe tło do zdjęć. Każdy event stanie się wyjątkowy i Instagram-owy!'); ?>
                                </p>
                            </div>
                            <div class="card-title-overlay">
                                <h4>Neonowe napisy</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- My w liczbach Section -->
<section
    class="stats-section py-5"
    style="
        background: rgba(255, 255, 255, 0.95);
        border-bottom-left-radius: 70px;
    "
    id="stats"
>
    <div class="container">
        <div class="text-center mb-5">
            <h3 style="color: #2c2c2c">
                <span style="color: #801039">My</span> w liczbach
            </h3>
        </div>

        <div class="row justify-content-center g-4">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div
                    class="stat-card text-center p-4"
                    style="
                        background: #801039;
                        color: white;
                        border-radius: 15px;
                        box-shadow: 0 8px 25px rgba(139, 75, 122, 0.3);
                        transition: transform 0.3s ease;
                    "
                >
                    <div
                        class="stat-number"
                        style="
                            font-size: 48px;
                            font-weight: bold;
                            margin-bottom: 10px;
                        "
                    >
                        0+
                    </div>
                    <div
                        class="stat-label"
                        style="font-size: 16px; font-weight: 500"
                    >
                        zadowolonych klientów
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div
                    class="stat-card text-center p-4"
                    style="
                        background: #801039;
                        color: white;
                        border-radius: 15px;
                        box-shadow: 0 8px 25px rgba(139, 75, 122, 0.3);
                        transition: transform 0.3s ease;
                    "
                >
                    <div
                        class="stat-number"
                        style="
                            font-size: 48px;
                            font-weight: bold;
                            margin-bottom: 10px;
                        "
                    >
                        0 lat
                    </div>
                    <div
                        class="stat-label"
                        style="font-size: 16px; font-weight: 500"
                    >
                        na rynku
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div
                    class="stat-card text-center p-4"
                    style="
                        background: #801039;
                        color: white;
                        border-radius: 15px;
                        box-shadow: 0 8px 25px rgba(139, 75, 122, 0.3);
                        transition: transform 0.3s ease;
                    "
                >
                    <div
                        class="stat-number"
                        style="
                            font-size: 48px;
                            font-weight: bold;
                            margin-bottom: 10px;
                        "
                    >
                        ∞
                    </div>
                    <div
                        class="stat-label"
                        style="font-size: 16px; font-weight: 500"
                    >
                        uśmiechów
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Galeria zdjęć Section -->
<section
    class="image-gallery-section py-5"
    style="background: rgba(139, 75, 122, 0.1)"
>
    <div class="container">
        <div class="text-center mb-5">
            <h3 style="color: #2c2c2c">
                Nasza <span style="color: #801039">galeria</span>
            </h3>
        </div>

        <div class="image-carousel-container">
            <button
                class="carousel-arrow carousel-arrow-left"
                onclick="prevImage()"
            >
                <svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M15 18L9 12L15 6"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </button>

            <div class="image-carousel">
                <div class="image-slide image-slide-left">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/360.png" alt="Fotobudka 360" />
                </div>

                <div class="image-slide image-slide-center active">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/mirror.jpg" alt="Fotolustro" />
                </div>

                <div class="image-slide image-slide-right">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/heavysmoke.jpg" alt="Ciężki dym" />
                </div>
            </div>

            <button
                class="carousel-arrow carousel-arrow-right"
                onclick="nextImage()"
            >
                <svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M9 18L15 12L9 6"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </button>
        </div>
    </div>
</section>

<?php get_footer(); ?>
