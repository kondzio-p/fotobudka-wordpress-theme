<?php
// Bezpieczeństwo - zapobiega bezpośredniemu dostępowi
if (!defined('ABSPATH')) {
    exit;
}

// Podstawowe funkcje motywu
function fotobudka_theme_setup() {
    // Dodaj wsparcie dla tytułów stron
    add_theme_support('title-tag');
    
    // Dodaj wsparcie dla miniaturek
    add_theme_support('post-thumbnails');
    
    // Dodaj wsparcie dla menu
    add_theme_support('menus');
    
    // Rejestruj menu
    register_nav_menus(array(
        'primary' => 'Menu główne',
    ));
}
add_action('after_setup_theme', 'fotobudka_theme_setup');

// Dodaj style i skrypty
function fotobudka_enqueue_scripts() {
    // CSS
    wp_enqueue_style('bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css');
    wp_enqueue_style('fotobudka-style', get_stylesheet_uri(), array(), time());
    
    // JavaScript
    wp_enqueue_script('gsap', 'https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js', array(), null, true);
    wp_enqueue_script('gsap-scrollto', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/ScrollToPlugin.min.js', array('gsap'), null, true);
    wp_enqueue_script('gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/ScrollTrigger.min.js', array('gsap'), null, true);
    wp_enqueue_script('fotobudka-script', get_template_directory_uri() . '/script.js', array('gsap'), null, true);
}
add_action('wp_enqueue_scripts', 'fotobudka_enqueue_scripts');

// Wyłącz Gutenberg (edytor blokowy) dla stron
function fotobudka_disable_gutenberg($current_status, $post_type) {
    if ($post_type === 'page') return false;
    return $current_status;
}
add_filter('use_block_editor_for_post_type', 'fotobudka_disable_gutenberg', 10, 2);

// Ukryj niepotrzebne elementy menu dla edytorów
function fotobudka_remove_menu_pages() {
    if (!current_user_can('administrator')) {
        remove_menu_page('themes.php');           // Wygląd
        remove_menu_page('plugins.php');          // Wtyczki
        remove_menu_page('tools.php');            // Narzędzia
        remove_menu_page('options-general.php');  // Ustawienia
        remove_submenu_page('themes.php', 'widgets.php');
        remove_submenu_page('themes.php', 'customize.php');
    }
}
add_action('admin_menu', 'fotobudka_remove_menu_pages');

// ============= NOWA SEKCJA - OBSŁUGA MEDIÓW =============

// Włącz obsługę mediów i biblioteki WordPress
add_theme_support('post-thumbnails');
add_theme_support('custom-logo');
add_theme_support('html5', array('gallery', 'caption'));

// Dodaj sizes dla obrazków
add_image_size('fotobudka-hero', 1920, 1080, true);
add_image_size('fotobudka-thumbnail', 400, 300, true);
add_image_size('fotobudka-gallery', 800, 600, true);

// Włącz edytor mediów
function fotobudka_editor_styles() {
    add_editor_style();
}
add_action('admin_init', 'fotobudka_editor_styles');

// Napraw upload mediów
function fotobudka_fix_media_upload() {
    if (function_exists('wp_enqueue_media')) {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'fotobudka_fix_media_upload');

// Dodaj Custom Fields dla strony głównej
function fotobudka_add_custom_fields() {
    add_meta_box(
        'fotobudka-images',
        'Zdjęcia i filmy strony głównej',
        'fotobudka_images_callback',
        'page'
    );
}
add_action('add_meta_boxes', 'fotobudka_add_custom_fields');

// Helper function to render media field
function render_media_field($name, $label, $value, $type = 'all') {
    echo '<tr><th><label>' . $label . ':</label></th><td>';
    echo '<div class="media-preview">';
    if ($value) {
        echo '<div class="current-file">Aktualny plik:</div>';
        // Check if it's an image or video
        $is_video = (strpos($value, '.mp4') !== false || strpos($value, '.webm') !== false || strpos($value, '.mov') !== false);
        if ($is_video) {
            echo '<video controls style="max-width: 200px;"><source src="' . esc_url($value) . '"></video><br>';
        } else {
            echo '<img src="' . esc_url($value) . '" alt="' . $label . '" style="max-width: 200px;"><br>';
        }
        echo '<small>' . esc_url($value) . '</small><br><br>';
    } else {
        echo '<div class="no-file">Brak wybranego pliku</div><br>';
    }
    echo '<input type="text" name="' . $name . '" value="' . esc_attr($value) . '" class="regular-text" placeholder="URL pliku" />';
    echo '<input type="button" class="button upload-button" value="Wybierz plik" />';
    echo '</div></td></tr>';
}

function fotobudka_images_callback($post) {
    wp_nonce_field('fotobudka_save_images', 'fotobudka_nonce');
    
    // SEKCJA HERO
    $hero_background = get_post_meta($post->ID, '_fotobudka_hero_background', true);
    $hero_title = get_post_meta($post->ID, '_fotobudka_hero_title', true);
    $hero_subtitle = get_post_meta($post->ID, '_fotobudka_hero_subtitle', true);
    
    // GALERIA GŁÓWNA (4 framki)
    $frame1_media = get_post_meta($post->ID, '_fotobudka_frame1_media', true);
    $frame1_caption = get_post_meta($post->ID, '_fotobudka_frame1_caption', true);
    $frame2_media = get_post_meta($post->ID, '_fotobudka_frame2_media', true);
    $frame2_caption = get_post_meta($post->ID, '_fotobudka_frame2_caption', true);
    $frame3_media = get_post_meta($post->ID, '_fotobudka_frame3_media', true);
    $frame3_caption = get_post_meta($post->ID, '_fotobudka_frame3_caption', true);
    $frame4_media = get_post_meta($post->ID, '_fotobudka_frame4_media', true);
    $frame4_caption = get_post_meta($post->ID, '_fotobudka_frame4_caption', true);
    
    // GALERIA KARUZELA
    $carousel_images = get_post_meta($post->ID, '_fotobudka_carousel_images', true);
    
    // USTAWIENIA STRONY
    $site_logo = get_post_meta($post->ID, '_fotobudka_site_logo', true);
    $primary_color = get_post_meta($post->ID, '_fotobudka_primary_color', true) ?: '#801039';
    $secondary_color = get_post_meta($post->ID, '_fotobudka_secondary_color', true) ?: '#8b4b7a';
    
    // STATYSTYKI
    $stat1_number = get_post_meta($post->ID, '_fotobudka_stat1_number', true) ?: '100+';
    $stat1_label = get_post_meta($post->ID, '_fotobudka_stat1_label', true) ?: 'zadowolonych klientów';
    $stat2_number = get_post_meta($post->ID, '_fotobudka_stat2_number', true) ?: '5 lat';
    $stat2_label = get_post_meta($post->ID, '_fotobudka_stat2_label', true) ?: 'na rynku';
    $stat3_number = get_post_meta($post->ID, '_fotobudka_stat3_number', true) ?: '∞';
    $stat3_label = get_post_meta($post->ID, '_fotobudka_stat3_label', true) ?: 'uśmiechów';
    
    echo '<style>
        .media-preview { margin: 10px 0; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        .media-preview img { max-width: 200px; height: auto; margin-right: 10px; }
        .media-preview video { max-width: 200px; height: auto; margin-right: 10px; }
        .current-file { font-weight: bold; color: #2271b1; }
        .no-file { font-style: italic; color: #666; }
        .section-title { background: #f1f1f1; padding: 10px; margin: 20px 0 10px 0; font-weight: bold; }
        .form-table th { width: 200px; }
        .color-picker { width: 100px; }
    </style>';
    
    echo '<div class="section-title">🎯 SEKCJA HERO</div>';
    echo '<table class="form-table">';
    render_media_field('hero_background', 'Hero tło (zdjęcie/film)', $hero_background);
    echo '<tr><th><label>Hero tytuł:</label></th><td>';
    echo '<input type="text" name="hero_title" value="' . esc_attr($hero_title) . '" class="regular-text" placeholder="Tytuł w sekcji hero" />';
    echo '</td></tr>';
    echo '<tr><th><label>Hero podtytuł:</label></th><td>';
    echo '<input type="text" name="hero_subtitle" value="' . esc_attr($hero_subtitle) . '" class="regular-text" placeholder="Podtytuł w sekcji hero" />';
    echo '</td></tr>';
    echo '</table>';
    
    echo '<div class="section-title">🖼️ GALERIA GŁÓWNA (4 framki)</div>';
    echo '<table class="form-table">';
    for ($i = 1; $i <= 4; $i++) {
        $media_var = "frame{$i}_media";
        $caption_var = "frame{$i}_caption";
        render_media_field("frame{$i}_media", "Ramka {$i} (plik)", $$media_var);
        echo '<tr><th><label>Ramka ' . $i . ' (podpis):</label></th><td>';
        echo '<input type="text" name="frame' . $i . '_caption" value="' . esc_attr($$caption_var) . '" class="regular-text" placeholder="Podpis pod ramką ' . $i . '" />';
        echo '</td></tr>';
    }
    echo '</table>';
    
    echo '<div class="section-title">🎠 GALERIA KARUZELA</div>';
    echo '<table class="form-table">';
    echo '<tr><th><label>Lista zdjęć galerii:</label></th><td>';
    echo '<div class="media-preview">';
    if ($carousel_images) {
        echo '<div class="current-file">Aktualne zdjęcia:</div>';
        $images = explode(',', $carousel_images);
        foreach ($images as $img_url) {
            $img_url = trim($img_url);
            if ($img_url) {
                echo '<img src="' . esc_url($img_url) . '" alt="Zdjęcie galerii" style="margin: 5px; max-width: 100px;">';
            }
        }
        echo '<br><br>';
    } else {
        echo '<div class="no-file">Brak zdjęć w galerii</div><br>';
    }
    echo '<textarea name="carousel_images" class="large-text" rows="4" placeholder="Wklej URLs zdjęć oddzielone przecinkami (8-10 zdjęć)">' . esc_textarea($carousel_images) . '</textarea>';
    echo '<br><input type="button" class="button upload-gallery-button" value="Wybierz zdjęcia (multi-select)" />';
    echo '<br><small><strong>Instrukcja:</strong> Kliknij przycisk, zaznacz kilka plików (Ctrl+klik), kliknij "Użyj tych plików"</small>';
    echo '</div></td></tr>';
    echo '</table>';
    
    echo '<div class="section-title">⚙️ USTAWIENIA STRONY</div>';
    echo '<table class="form-table">';
    render_media_field('site_logo', 'Logo główne', $site_logo);
    echo '<tr><th><label>Kolor główny:</label></th><td>';
    echo '<input type="color" name="primary_color" value="' . esc_attr($primary_color) . '" class="color-picker" />';
    echo '<input type="text" name="primary_color_text" value="' . esc_attr($primary_color) . '" class="regular-text" style="width: 100px; margin-left: 10px;" />';
    echo '</td></tr>';
    echo '<tr><th><label>Kolor pomocniczy:</label></th><td>';
    echo '<input type="color" name="secondary_color" value="' . esc_attr($secondary_color) . '" class="color-picker" />';
    echo '<input type="text" name="secondary_color_text" value="' . esc_attr($secondary_color) . '" class="regular-text" style="width: 100px; margin-left: 10px;" />';
    echo '</td></tr>';
    echo '</table>';
    
    echo '<div class="section-title">📊 STATYSTYKI (My w liczbach)</div>';
    echo '<table class="form-table">';
    echo '<tr><th><label>Statystyka 1:</label></th><td>';
    echo '<input type="text" name="stat1_number" value="' . esc_attr($stat1_number) . '" style="width: 100px;" placeholder="100+" /> ';
    echo '<input type="text" name="stat1_label" value="' . esc_attr($stat1_label) . '" class="regular-text" placeholder="zadowolonych klientów" />';
    echo '</td></tr>';
    echo '<tr><th><label>Statystyka 2:</label></th><td>';
    echo '<input type="text" name="stat2_number" value="' . esc_attr($stat2_number) . '" style="width: 100px;" placeholder="5 lat" /> ';
    echo '<input type="text" name="stat2_label" value="' . esc_attr($stat2_label) . '" class="regular-text" placeholder="na rynku" />';
    echo '</td></tr>';
    echo '<tr><th><label>Statystyka 3:</label></th><td>';
    echo '<input type="text" name="stat3_number" value="' . esc_attr($stat3_number) . '" style="width: 100px;" placeholder="∞" /> ';
    echo '<input type="text" name="stat3_label" value="' . esc_attr($stat3_label) . '" class="regular-text" placeholder="uśmiechów" />';
    echo '</td></tr>';
    echo '</table>';
    
    // ULEPSZONY JAVASCRIPT
    ?>
    <script>
    jQuery(document).ready(function($) {
        // Sync color picker with text input
        $('input[type="color"]').on('change', function() {
            $(this).next('input[type="text"]').val($(this).val());
        });
        
        $('input[name*="color_text"]').on('change', function() {
            $(this).prev('input[type="color"]').val($(this).val());
        });
        
        // Przycisk dla pojedynczych plików
        $('.upload-button').click(function(e) {
            e.preventDefault();
            var button = $(this);
            var input = button.prev('input');
            
            var media_uploader = wp.media({
                title: 'Wybierz plik',
                button: { text: 'Użyj tego pliku' },
                multiple: false
            });
            
            media_uploader.on('select', function() {
                var attachment = media_uploader.state().get('selection').first().toJSON();
                input.val(attachment.url);
                
                // Odśwież stronę żeby pokazać podgląd
                alert('Plik wybrany! Zapisz stronę aby zobaczyć podgląd.');
            });
            
            media_uploader.open();
        });
        
        // Przycisk dla galerii (wiele plików)
        $('.upload-gallery-button').click(function(e) {
            e.preventDefault();
            var textarea = $(this).prevAll('textarea').first();
            
            var media_uploader = wp.media({
                title: 'Wybierz zdjęcia dla galerii (8-10 plików)',
                button: { text: 'Użyj tych plików' },
                multiple: true
            });
            
            media_uploader.on('select', function() {
                var attachments = media_uploader.state().get('selection').toJSON();
                var urls = [];
                
                attachments.forEach(function(attachment) {
                    urls.push(attachment.url);
                });
                
                textarea.val(urls.join(', '));
                alert('Zdjęcia wybrane! Zapisz stronę aby zobaczyć podgląd.');
            });
            
            media_uploader.open();
        });
    });
    </script>
    <?php
}

// Zapisz custom fields
function fotobudka_save_images($post_id) {
    if (!isset($_POST['fotobudka_nonce']) || !wp_verify_nonce($_POST['fotobudka_nonce'], 'fotobudka_save_images')) {
        return;
    }
    
    // SEKCJA HERO
    if (isset($_POST['hero_background'])) {
        update_post_meta($post_id, '_fotobudka_hero_background', sanitize_text_field($_POST['hero_background']));
    }
    if (isset($_POST['hero_title'])) {
        update_post_meta($post_id, '_fotobudka_hero_title', sanitize_text_field($_POST['hero_title']));
    }
    if (isset($_POST['hero_subtitle'])) {
        update_post_meta($post_id, '_fotobudka_hero_subtitle', sanitize_text_field($_POST['hero_subtitle']));
    }
    
    // GALERIA GŁÓWNA (4 framki)
    for ($i = 1; $i <= 4; $i++) {
        if (isset($_POST["frame{$i}_media"])) {
            update_post_meta($post_id, "_fotobudka_frame{$i}_media", sanitize_text_field($_POST["frame{$i}_media"]));
        }
        if (isset($_POST["frame{$i}_caption"])) {
            update_post_meta($post_id, "_fotobudka_frame{$i}_caption", sanitize_text_field($_POST["frame{$i}_caption"]));
        }
    }
    
    // GALERIA KARUZELA
    if (isset($_POST['carousel_images'])) {
        update_post_meta($post_id, '_fotobudka_carousel_images', sanitize_textarea_field($_POST['carousel_images']));
    }
    
    // USTAWIENIA STRONY
    if (isset($_POST['site_logo'])) {
        update_post_meta($post_id, '_fotobudka_site_logo', sanitize_text_field($_POST['site_logo']));
    }
    if (isset($_POST['primary_color_text'])) {
        update_post_meta($post_id, '_fotobudka_primary_color', sanitize_hex_color($_POST['primary_color_text']));
    }
    if (isset($_POST['secondary_color_text'])) {
        update_post_meta($post_id, '_fotobudka_secondary_color', sanitize_hex_color($_POST['secondary_color_text']));
    }
    
    // STATYSTYKI
    if (isset($_POST['stat1_number'])) {
        update_post_meta($post_id, '_fotobudka_stat1_number', sanitize_text_field($_POST['stat1_number']));
    }
    if (isset($_POST['stat1_label'])) {
        update_post_meta($post_id, '_fotobudka_stat1_label', sanitize_text_field($_POST['stat1_label']));
    }
    if (isset($_POST['stat2_number'])) {
        update_post_meta($post_id, '_fotobudka_stat2_number', sanitize_text_field($_POST['stat2_number']));
    }
    if (isset($_POST['stat2_label'])) {
        update_post_meta($post_id, '_fotobudka_stat2_label', sanitize_text_field($_POST['stat2_label']));
    }
    if (isset($_POST['stat3_number'])) {
        update_post_meta($post_id, '_fotobudka_stat3_number', sanitize_text_field($_POST['stat3_number']));
    }
    if (isset($_POST['stat3_label'])) {
        update_post_meta($post_id, '_fotobudka_stat3_label', sanitize_text_field($_POST['stat3_label']));
    }
}
add_action('save_post', 'fotobudka_save_images');

// Helper functions to get custom field values with fallbacks
function get_fotobudka_hero_background($post_id = null) {
    if (!$post_id) $post_id = get_the_ID();
    $value = get_post_meta($post_id, '_fotobudka_hero_background', true);
    return $value ?: get_template_directory_uri() . '/videos/film1.mp4';
}

function get_fotobudka_hero_title($post_id = null) {
    if (!$post_id) $post_id = get_the_ID();
    $value = get_post_meta($post_id, '_fotobudka_hero_title', true);
    return $value ?: 'Witamy w <span style="color: #801039; font-weight: bold">Fotobudka Chojnice!</span>';
}

function get_fotobudka_hero_subtitle($post_id = null) {
    if (!$post_id) $post_id = get_the_ID();
    $value = get_post_meta($post_id, '_fotobudka_hero_subtitle', true);
    return $value ?: 'Dopełniamy, by na Twoim wydarzeniu nie zabrakło Atrakcji!';
}

function get_fotobudka_frame_media($frame_number, $post_id = null) {
    if (!$post_id) $post_id = get_the_ID();
    $value = get_post_meta($post_id, "_fotobudka_frame{$frame_number}_media", true);
    // Fallback to existing videos
    $fallbacks = [
        1 => get_template_directory_uri() . '/videos/film1.mp4',
        2 => get_template_directory_uri() . '/videos/film2.mp4', 
        3 => get_template_directory_uri() . '/videos/film1.mp4',
        4 => get_template_directory_uri() . '/videos/film2.mp4'
    ];
    return $value ?: $fallbacks[$frame_number];
}

function get_fotobudka_frame_caption($frame_number, $post_id = null) {
    if (!$post_id) $post_id = get_the_ID();
    return get_post_meta($post_id, "_fotobudka_frame{$frame_number}_caption", true);
}

function get_fotobudka_carousel_images($post_id = null) {
    if (!$post_id) $post_id = get_the_ID();
    $value = get_post_meta($post_id, '_fotobudka_carousel_images', true);
    if ($value) {
        return array_map('trim', explode(',', $value));
    }
    // Fallback to default images
    $base_url = get_template_directory_uri();
    return [
        $base_url . '/images/360.png',
        $base_url . '/images/mirror.jpg', 
        $base_url . '/images/heavysmoke.jpg',
        $base_url . '/images/fountain.jpg',
        $base_url . '/images/neons.jpg'
    ];
}

function get_fotobudka_site_logo($post_id = null) {
    if (!$post_id) $post_id = get_the_ID();
    $value = get_post_meta($post_id, '_fotobudka_site_logo', true);
    return $value ?: get_template_directory_uri() . '/images/og-events-logo-white.png';
}

function get_fotobudka_primary_color($post_id = null) {
    if (!$post_id) $post_id = get_the_ID();
    $value = get_post_meta($post_id, '_fotobudka_primary_color', true);
    return $value ?: '#801039';
}

function get_fotobudka_secondary_color($post_id = null) {
    if (!$post_id) $post_id = get_the_ID();
    $value = get_post_meta($post_id, '_fotobudka_secondary_color', true);
    return $value ?: '#8b4b7a';
}

function get_fotobudka_stat($stat_number, $type = 'number', $post_id = null) {
    if (!$post_id) $post_id = get_the_ID();
    $value = get_post_meta($post_id, "_fotobudka_stat{$stat_number}_{$type}", true);
    $defaults = [
        '1_number' => '100+',
        '1_label' => 'zadowolonych klientów',
        '2_number' => '5 lat', 
        '2_label' => 'na rynku',
        '3_number' => '∞',
        '3_label' => 'uśmiechów'
    ];
    return $value ?: $defaults["{$stat_number}_{$type}"];
}

// ============= KONIEC NOWEJ SEKCJI MEDIÓW =============

// Dodaj wsparcie dla ACF (jeśli jest zainstalowane)
function fotobudka_acf_init() {
    if (function_exists('acf_add_local_field_group')) {
        // Grupa pól dla strony głównej
        acf_add_local_field_group(array(
            'key' => 'group_strona_glowna',
            'title' => 'Edycja treści strony głównej',
            'fields' => array(
                array(
                    'key' => 'field_tytul_glowny',
                    'label' => 'Tytuł główny',
                    'name' => 'tytul_glowny',
                    'type' => 'text',
                    'default_value' => 'Witamy w Fotobudka Chojnice!',
                ),
                array(
                    'key' => 'field_podtytul_glowny',
                    'label' => 'Podtytuł główny',
                    'name' => 'podtytul_glowny',
                    'type' => 'text',
                    'default_value' => 'Dopełniamy, by na Twoim wydarzeniu nie zabrakło Atrakcji!',
                ),
                array(
                    'key' => 'field_telefon',
                    'label' => 'Numer telefonu',
                    'name' => 'telefon',
                    'type' => 'text',
                    'default_value' => '727 323 442',
                ),
                array(
                    'key' => 'field_facebook_url',
                    'label' => 'Link do Facebook',
                    'name' => 'facebook_url',
                    'type' => 'url',
                    'default_value' => 'https://www.facebook.com/profile.php?id=61553668165091',
                ),
                array(
                    'key' => 'field_instagram_url',
                    'label' => 'Link do Instagram',
                    'name' => 'instagram_url',
                    'type' => 'url',
                    'default_value' => 'https://www.instagram.com/og.eventspot/',
                ),
                // Pola dla ofert
                array(
                    'key' => 'field_oferta_360_opis',
                    'label' => 'Opis Fotobudki 360',
                    'name' => 'oferta_360_opis',
                    'type' => 'textarea',
                    'default_value' => 'Wejdź do centrum uwagi z naszą obrotową fotobudką 360°! Twórz spektakularne, dynamiczne filmy w zwolnionym tempie. Idealne na wesela, imprezy firmowe i urodziny. Gwarantujemy niezapomniane wspomnienia i mnóstwo zabawy dla wszystkich gości.',
                ),
                array(
                    'key' => 'field_oferta_mirror_opis',
                    'label' => 'Opis Fotolustra',
                    'name' => 'oferta_mirror_opis',
                    'type' => 'textarea',
                    'default_value' => 'Magiczne lustro, które robi zdjęcia! Interaktywne fotolustro z animacjami i zabawnymi dodatkami. Goście mogą pozować, robić selfie i od razu drukować pamiątkowe zdjęcia. Doskonałe na każdą okazję - od eleganckich eventów po szalone imprezy.',
                ),
                array(
                    'key' => 'field_oferta_smoke_opis',
                    'label' => 'Opis Ciężkiego dymu',
                    'name' => 'oferta_smoke_opis',
                    'type' => 'textarea',
                    'default_value' => 'Stwórz bajkową atmosferę z naszym efektem ciężkiego dymu! Gęsta, biała mgła unosi się przy ziemi, tworząc magiczny klimat podczas pierwszego tańca, wejścia pary młodej czy kluczowych momentów imprezy. Całkowicie bezpieczny i spektakularny.',
                ),
                array(
                    'key' => 'field_oferta_fountain_opis',
                    'label' => 'Opis Fontann iskier',
                    'name' => 'oferta_fountain_opis',
                    'type' => 'textarea',
                    'default_value' => 'Wybuchaj radością z naszymi fontannami iskier! Zimne ognie tworzą oszałamiające efekty świetlne bez zagrożenia. Idealne na tort weselny, pierwsze wejście czy kulminacyjne momenty imprezy. Bezpieczne, efektowne i niezapomniane dla wszystkich gości.',
                ),
                array(
                    'key' => 'field_oferta_neons_opis',
                    'label' => 'Opis Neonowych napisów',
                    'name' => 'oferta_neons_opis',
                    'type' => 'textarea',
                    'default_value' => 'Świeć jaśniej niż gwiazdy z naszymi neonowymi napisami LED! Personalizowane napisy z imionami, datami lub hasłami. Kolorowe podświetlenie tworzy niesamowity klimat i doskonałe tło do zdjęć. Każdy event stanie się wyjątkowy i Instagram-owy!',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'page_template',
                        'operator' => '==',
                        'value' => 'default',
                    ),
                ),
            ),
        ));

        // Grupa pól dla stron miast
        acf_add_local_field_group(array(
            'key' => 'group_strona_miasto',
            'title' => 'Edycja treści dla miasta',
            'fields' => array(
                array(
                    'key' => 'field_nazwa_miasta',
                    'label' => 'Nazwa miasta',
                    'name' => 'nazwa_miasta',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_miasto_telefon',
                    'label' => 'Numer telefonu dla tego miasta',
                    'name' => 'miasto_telefon',
                    'type' => 'text',
                    'default_value' => '727 323 442',
                ),
                array(
                    'key' => 'field_miasto_opis',
                    'label' => 'Dodatkowy opis dla tego miasta',
                    'name' => 'miasto_opis',
                    'type' => 'textarea',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'page_template',
                        'operator' => '==',
                        'value' => 'page-miasto.php',
                    ),
                ),
            ),
        ));
    }
}
add_action('acf/init', 'fotobudka_acf_init');

// Niestandardowa rola dla klienta
function fotobudka_add_client_role() {
    add_role('klient_fotobudka', 'Klient Fotobudka', array(
        'read' => true,
        'edit_pages' => true,
        'edit_published_pages' => true,
        'upload_files' => true,
    ));
}
add_action('init', 'fotobudka_add_client_role');

// Funkcja pomocnicza do pobierania wartości ACF
function get_acf_value($field_name, $default = '') {
    if (function_exists('get_field')) {
        $value = get_field($field_name);
        return $value ? $value : $default;
    }
    return $default;
}
?>