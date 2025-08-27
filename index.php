<?php get_header(); ?>

<main class="main-content">
    <div class="photo-gallery">
        <?php
        // Get video frame data for dynamic display
        for ($frame = 1; $frame <= 4; $frame++) {
            $frame_data = get_fotobudka_video_frame($frame);
            
            echo '<div class="photo-frame">';
            
            if ($frame_data['has_custom_video']) {
                // Use custom video
                echo '<video
                    src="' . esc_url($frame_data['video_url']) . '"
                    alt="Event video ' . $frame . '"
                    autoplay
                    muted
                    loop
                    playsinline
                    data-start-time="' . esc_attr($frame_data['start_time']) . '"';
                    
                if ($frame_data['fallback_image']) {
                    $fallback_b64 = base64_encode('<svg width="280" height="320" viewBox="0 0 280 320" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="280" height="320" fill="#F0F0F0"/><text x="140" y="165" text-anchor="middle" fill="#999" font-family="Arial" font-size="14">Event Video ' . $frame . '</text></svg>');
                    echo ' onerror="this.outerHTML=\'<img src=\\\'' . esc_url($frame_data['fallback_image']) . '\\\' alt=\\\'Event Video ' . $frame . '\\\' style=\\\'width: 100%; height: 100%; object-fit: cover;\\\' onerror=\\\'this.src=\\\"data:image/svg+xml;base64,' . $fallback_b64 . '\\\";\\\'/>\';"';
                } else {
                    $fallback_b64 = base64_encode('<svg width="280" height="320" viewBox="0 0 280 320" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="280" height="320" fill="#F0F0F0"/><text x="140" y="165" text-anchor="middle" fill="#999" font-family="Arial" font-size="14">Event Video ' . $frame . '</text></svg>');
                    echo ' onerror="this.outerHTML=\'<img src=\\\'data:image/svg+xml;base64,' . $fallback_b64 . '\\\' alt=\\\'Event Video ' . $frame . '\\\'/>\';"';
                }
                
                echo '></video>';
            } else {
                // Use default video as fallback
                $default_videos = [1 => 'film1.mp4', 2 => 'film2.mp4', 3 => 'film1.mp4', 4 => 'film2.mp4'];
                $default_video = $default_videos[$frame];
                $fallback_b64 = base64_encode('<svg width="280" height="320" viewBox="0 0 280 320" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="280" height="320" fill="#F0F0F0"/><text x="140" y="165" text-anchor="middle" fill="#999" font-family="Arial" font-size="14">Event Video ' . $frame . '</text></svg>');
                
                echo '<video
                    src="' . get_template_directory_uri() . '/videos/' . $default_video . '"
                    alt="Event video ' . $frame . '"
                    autoplay
                    muted
                    loop
                    playsinline
                    data-start-time="' . esc_attr($frame_data['start_time']) . '"
                    onerror="this.outerHTML=\'<img src=\\\'data:image/svg+xml;base64,' . $fallback_b64 . '\\\' alt=\\\'Event Video ' . $frame . '\\\'/>\';"
                ></video>';
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
                <?php
                $gallery_images = get_fotobudka_gallery_images();
                $default_images = [
                    get_template_directory_uri() . '/images/360.png',
                    get_template_directory_uri() . '/images/mirror.jpg',
                    get_template_directory_uri() . '/images/heavysmoke.jpg',
                    get_template_directory_uri() . '/images/fountain.jpg',
                    get_template_directory_uri() . '/images/neons.jpg'
                ];
                
                // Use custom gallery images if available, otherwise use defaults
                $images_to_display = !empty($gallery_images) ? $gallery_images : $default_images;
                
                // Display first three images (or what's available)
                $positions = ['left', 'center', 'right'];
                for ($i = 0; $i < 3 && $i < count($images_to_display); $i++) {
                    $position = $positions[$i];
                    $active_class = $position === 'center' ? ' active' : '';
                    $image_url = $images_to_display[$i];
                    
                    echo '<div class="image-slide image-slide-' . $position . $active_class . '">';
                    echo '<img data-src="' . esc_url($image_url) . '" alt="Gallery image" loading="lazy" class="gallery-lazy" />';
                    echo '</div>';
                }
                
                // If we have fewer than 3 images, fill with defaults
                if (count($images_to_display) < 3) {
                    for ($i = count($images_to_display); $i < 3; $i++) {
                        $position = $positions[$i];
                        $active_class = $position === 'center' ? ' active' : '';
                        $default_img = $default_images[$i % count($default_images)];
                        
                        echo '<div class="image-slide image-slide-' . $position . $active_class . '">';
                        echo '<img data-src="' . esc_url($default_img) . '" alt="Default gallery image" loading="lazy" class="gallery-lazy" style="opacity: 0.7;" />';
                        echo '</div>';
                    }
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
