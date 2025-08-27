<?php get_header(); ?>

<!-- Hero Section -->
<?php 
$hero_bg = get_fotobudka_hero_background();
$is_hero_video = (strpos($hero_bg, '.mp4') !== false || strpos($hero_bg, '.webm') !== false || strpos($hero_bg, '.mov') !== false);
?>
<section class="hero-section" style="position: relative; min-height: 60vh; display: flex; align-items: center; justify-content: center; overflow: hidden;">
    <?php if ($is_hero_video): ?>
        <video 
            autoplay 
            muted 
            loop 
            playsinline 
            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: -1;"
            onerror="this.style.display='none';"
        >
            <source src="<?php echo esc_url($hero_bg); ?>" type="video/mp4">
        </video>
    <?php else: ?>
        <div style="
            position: absolute; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            background-image: url('<?php echo esc_url($hero_bg); ?>'); 
            background-size: cover; 
            background-position: center; 
            z-index: -1;
        "></div>
    <?php endif; ?>
    
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); z-index: 0;"></div>
    
    <div class="container text-center" style="position: relative; z-index: 1; color: white;">
        <h1 style="font-size: 3rem; margin-bottom: 1rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
            <?php echo get_fotobudka_hero_title(); ?>
        </h1>
        <p style="font-size: 1.3rem; margin-bottom: 2rem; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
            <?php echo get_fotobudka_hero_subtitle(); ?>
        </p>
    </div>
</section>

<main class="main-content">
    <div class="photo-gallery"><?php
    // Generate the 4 frames dynamically
    for ($i = 1; $i <= 4; $i++) {
        $frame_media = get_fotobudka_frame_media($i);
        $frame_caption = get_fotobudka_frame_caption($i);
        $is_video = (strpos($frame_media, '.mp4') !== false || strpos($frame_media, '.webm') !== false || strpos($frame_media, '.mov') !== false);
        
        echo '<div class="photo-frame">';
        if ($is_video) {
            echo '<video
                src="' . esc_url($frame_media) . '"
                alt="Event video ' . $i . '"
                autoplay
                muted
                loop
                playsinline
                data-start-time="' . ($i * 2 + 1) . '"
                onerror="this.outerHTML=\'<img src=\\\'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjgwIiBoZWlnaHQ9IjMyMCIgdmlld0JveD0iMCAwIDI4MCAzMjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIyODAiIGhlaWdodD0iMzIwIiBmaWxsPSIjRjBGMEYwIi8+Cjx0ZXh0IHg9IjE0MCIgeT0iMTY1IiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmaWxsPSIjOTk5IiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTQiPkV2ZW50IFZpZGVvICcg. $i . \'PC90ZXh0Pgo8L3N2Zz4=\\\' alt=\\\'Event Video ' . $i . '\\\'/>\';"
            ></video>';
        } else {
            echo '<img 
                src="' . esc_url($frame_media) . '" 
                alt="Event image ' . $i . '"
                style="width: 100%; height: 100%; object-fit: cover;"
                onerror="this.outerHTML=\'<img src=\\\'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjgwIiBoZWlnaHQ9IjMyMCIgdmlld0JveD0iMCAwIDI4MCAzMjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIyODAiIGhlaWdodD0iMzIwIiBmaWxsPSIjRjBGMEYwIi8+Cjx0ZXh0IHg9IjE0MCIgeT0iMTY1IiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmaWxsPSIjOTk5IiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTQiPkV2ZW50IEltYWdlICcg. $i . \'PC90ZXh0Pgo8L3N2Zz4=\\\' alt=\\\'Event Image ' . $i . '\\\'/>\';"
            />';
        }
        if ($frame_caption) {
            echo '<div class="frame-caption" style="position: absolute; bottom: 10px; left: 10px; right: 10px; background: rgba(0,0,0,0.7); color: white; padding: 8px; border-radius: 4px; font-size: 0.9rem;">' . esc_html($frame_caption) . '</div>';
        }
        echo '</div>';
    }
    ?>
    </div>
</main>

<!-- Welcome Section -->
<section id="welcome" class="welcome-section">
    <div class="container-fluid px-0">
        <div
            class="welcome-header text-center py-5"
            style="background: rgba(255, 255, 255, 0.9)"
        >
            <h2 class="mb-3">
                <?php echo get_acf_value('tytul_glowny', 'Witamy w <span style="color: #801039; font-weight: bold">Fotobudka Chojnice!</span>'); ?>
            </h2>
            <p class="lead" style="color: #666">
                <?php echo get_acf_value('podtytul_glowny', 'Dopełniamy, by na Twoim wydarzeniu nie zabrakło Atrakcji!'); ?>
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
                    Nasza <span style="color: #801039">oferta</span>
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
                        background: <?php echo get_fotobudka_primary_color(); ?>;
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
                        <?php echo get_fotobudka_stat(1, 'number'); ?>
                    </div>
                    <div
                        class="stat-label"
                        style="font-size: 16px; font-weight: 500"
                    >
                        <?php echo get_fotobudka_stat(1, 'label'); ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div
                    class="stat-card text-center p-4"
                    style="
                        background: <?php echo get_fotobudka_primary_color(); ?>;
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
                        <?php echo get_fotobudka_stat(2, 'number'); ?>
                    </div>
                    <div
                        class="stat-label"
                        style="font-size: 16px; font-weight: 500"
                    >
                        <?php echo get_fotobudka_stat(2, 'label'); ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div
                    class="stat-card text-center p-4"
                    style="
                        background: <?php echo get_fotobudka_primary_color(); ?>;
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
                        <?php echo get_fotobudka_stat(3, 'number'); ?>
                    </div>
                    <div
                        class="stat-label"
                        style="font-size: 16px; font-weight: 500"
                    >
                        <?php echo get_fotobudka_stat(3, 'label'); ?>
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
                <?php 
                $carousel_images = get_fotobudka_carousel_images();
                $total_images = count($carousel_images);
                
                foreach ($carousel_images as $index => $image_url) {
                    $position_class = '';
                    if ($index == 0) $position_class = 'image-slide-left';
                    else if ($index == 1) $position_class = 'image-slide-center active';
                    else if ($index == 2) $position_class = 'image-slide-right';
                    else $position_class = 'image-slide-hidden'; // For images beyond the first 3
                    
                    echo '<div class="image-slide ' . $position_class . '" data-index="' . $index . '">';
                    echo '<img src="' . esc_url($image_url) . '" alt="Galeria zdjęcie ' . ($index + 1) . '" 
                        onerror="this.outerHTML=\'<img src=\\\'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjRjBGMEYwIi8+Cjx0ZXh0IHg9IjIwMCIgeT0iMTUwIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmaWxsPSIjOTk5IiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTYiPkdhbGVyaWEgWmRqxJljaWU8L3RleHQ+Cjwvc3ZnPg==\\\' alt=\\\'Galeria zdjęcie ' . ($index + 1) . '\\\'/>\';" />';
                    echo '</div>';
                }
                ?>
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
