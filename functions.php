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

function fotobudka_images_callback($post) {
    wp_nonce_field('fotobudka_save_images', 'fotobudka_nonce');
    
    // Existing fields
    $hero_image = get_post_meta($post->ID, '_fotobudka_hero_image', true);
    $hero_video = get_post_meta($post->ID, '_fotobudka_hero_video', true);
    $gallery_images = get_post_meta($post->ID, '_fotobudka_gallery_images', true);
    
    // New video frame fields
    $video_frame_1 = get_post_meta($post->ID, '_fotobudka_video_frame_1', true);
    $video_frame_1_start = get_post_meta($post->ID, '_fotobudka_video_frame_1_start', true) ?: '7';
    $video_frame_1_fallback = get_post_meta($post->ID, '_fotobudka_video_frame_1_fallback', true);
    
    $video_frame_2 = get_post_meta($post->ID, '_fotobudka_video_frame_2', true);
    $video_frame_2_start = get_post_meta($post->ID, '_fotobudka_video_frame_2_start', true) ?: '3';
    $video_frame_2_fallback = get_post_meta($post->ID, '_fotobudka_video_frame_2_fallback', true);
    
    $video_frame_3 = get_post_meta($post->ID, '_fotobudka_video_frame_3', true);
    $video_frame_3_start = get_post_meta($post->ID, '_fotobudka_video_frame_3_start', true) ?: '2';
    $video_frame_3_fallback = get_post_meta($post->ID, '_fotobudka_video_frame_3_fallback', true);
    
    $video_frame_4 = get_post_meta($post->ID, '_fotobudka_video_frame_4', true);
    $video_frame_4_start = get_post_meta($post->ID, '_fotobudka_video_frame_4_start', true) ?: '4';
    $video_frame_4_fallback = get_post_meta($post->ID, '_fotobudka_video_frame_4_fallback', true);
    
    // New offer card background fields
    $offer_360_bg = get_post_meta($post->ID, '_fotobudka_offer_360_bg', true);
    $offer_mirror_bg = get_post_meta($post->ID, '_fotobudka_offer_mirror_bg', true);
    $offer_smoke_bg = get_post_meta($post->ID, '_fotobudka_offer_smoke_bg', true);
    $offer_fountain_bg = get_post_meta($post->ID, '_fotobudka_offer_fountain_bg', true);
    $offer_neons_bg = get_post_meta($post->ID, '_fotobudka_offer_neons_bg', true);
    
    echo '<style>
        .fotobudka-tabs { margin-bottom: 20px; border-bottom: 1px solid #ccc; }
        .fotobudka-tabs .nav-tab { padding: 8px 12px; margin-left: 0; margin-right: 5px; text-decoration: none; border: 1px solid #ccc; border-bottom: none; background: #f1f1f1; color: #555; }
        .fotobudka-tabs .nav-tab.nav-tab-active { background: #fff; border-bottom: 1px solid #fff; color: #000; }
        .fotobudka-tab-content { display: none; padding: 20px 0; }
        .fotobudka-tab-content.active { display: block; }
        .media-preview { margin: 10px 0; padding: 15px; border: 1px solid #ddd; border-radius: 8px; background: #f9f9f9; }
        .media-preview img { max-width: 200px; height: auto; margin-right: 10px; border-radius: 4px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .media-preview video { max-width: 200px; height: auto; margin-right: 10px; border-radius: 4px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .current-file { font-weight: bold; color: #2271b1; margin-bottom: 8px; }
        .no-file { font-style: italic; color: #666; margin-bottom: 8px; }
        .media-input-group { display: flex; gap: 8px; align-items: center; margin-top: 8px; }
        .media-input-group input[type="text"] { flex: 1; }
        .media-input-group input[type="number"] { width: 80px; }
        .video-frame-section { border: 1px solid #e0e0e0; border-radius: 6px; padding: 15px; margin-bottom: 15px; background: #fafafa; }
        .video-frame-title { font-weight: bold; color: #23282d; margin-bottom: 10px; font-size: 14px; }
        .offer-card-section { border: 1px solid #e0e0e0; border-radius: 6px; padding: 15px; margin-bottom: 15px; background: #fafafa; }
        .offer-card-title { font-weight: bold; color: #23282d; margin-bottom: 10px; font-size: 14px; }
        .gallery-preview { display: flex; flex-wrap: wrap; gap: 10px; margin: 10px 0; }
        .gallery-preview img { width: 120px; height: 90px; object-fit: cover; border-radius: 4px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
    </style>';
    
    // Tab navigation
    echo '<div class="fotobudka-tabs">';
    echo '<a href="#" class="nav-tab nav-tab-active" data-tab="hero">Główne Media</a>';
    echo '<a href="#" class="nav-tab" data-tab="frames">Ramki Wideo</a>';
    echo '<a href="#" class="nav-tab" data-tab="gallery">Galeria</a>';
    echo '<a href="#" class="nav-tab" data-tab="offers">Karty Ofert</a>';
    echo '</div>';
    
    // Hero Section Tab
    echo '<div id="tab-hero" class="fotobudka-tab-content active">';
    echo '<h3>Główne Media Strony</h3>';
    echo '<table class="form-table">';
    
    // GŁÓWNE ZDJĘCIE
    echo '<tr><th><label>Główne zdjęcie:</label></th><td>';
    echo '<div class="media-preview">';
    if ($hero_image) {
        echo '<div class="current-file">Aktualny plik:</div>';
        echo '<img src="' . esc_url($hero_image) . '" alt="Główne zdjęcie"><br>';
        echo '<small>' . esc_url($hero_image) . '</small><br>';
    } else {
        echo '<div class="no-file">Brak wybranego zdjęcia</div>';
    }
    echo '<div class="media-input-group">';
    echo '<input type="text" name="hero_image" value="' . esc_attr($hero_image) . '" class="regular-text" placeholder="URL nowego zdjęcia" />';
    echo '<input type="button" class="button upload-button" value="Wybierz zdjęcie" />';
    echo '</div>';
    echo '</div></td></tr>';
    
    // GŁÓWNY FILM
    echo '<tr><th><label>Główny film:</label></th><td>';
    echo '<div class="media-preview">';
    if ($hero_video) {
        echo '<div class="current-file">Aktualny plik:</div>';
        if (strpos($hero_video, '.mp4') !== false || strpos($hero_video, '.webm') !== false) {
            echo '<video controls><source src="' . esc_url($hero_video) . '"></video><br>';
        }
        echo '<small>' . esc_url($hero_video) . '</small><br>';
    } else {
        echo '<div class="no-file">Brak wybranego filmu</div>';
    }
    echo '<div class="media-input-group">';
    echo '<input type="text" name="hero_video" value="' . esc_attr($hero_video) . '" class="regular-text" placeholder="URL nowego filmu" />';
    echo '<input type="button" class="button upload-button" value="Wybierz film" />';
    echo '</div>';
    echo '</div></td></tr>';
    
    echo '</table>';
    echo '</div>';
    
    // Video Frames Tab  
    echo '<div id="tab-frames" class="fotobudka-tab-content">';
    echo '<h3>Ramki Wideo (4 klatki)</h3>';
    echo '<p><em>Skonfiguruj filmy wyświetlane w ramkach na stronie głównej. Każda ramka może mieć własny film, czas startu i obrazek zastępczy.</em></p>';
    
    $frames = [
        ['num' => 1, 'video' => $video_frame_1, 'start' => $video_frame_1_start, 'fallback' => $video_frame_1_fallback, 'name' => 'Ramka 1 (lewy górny)'],
        ['num' => 2, 'video' => $video_frame_2, 'start' => $video_frame_2_start, 'fallback' => $video_frame_2_fallback, 'name' => 'Ramka 2 (prawy górny)'], 
        ['num' => 3, 'video' => $video_frame_3, 'start' => $video_frame_3_start, 'fallback' => $video_frame_3_fallback, 'name' => 'Ramka 3 (lewy dolny)'],
        ['num' => 4, 'video' => $video_frame_4, 'start' => $video_frame_4_start, 'fallback' => $video_frame_4_fallback, 'name' => 'Ramka 4 (prawy dolny)']
    ];
    
    foreach ($frames as $frame) {
        echo '<div class="video-frame-section">';
        echo '<div class="video-frame-title">' . $frame['name'] . '</div>';
        
        echo '<table class="form-table">';
        
        // Video
        echo '<tr><th><label>Film:</label></th><td>';
        echo '<div class="media-preview">';
        if ($frame['video']) {
            echo '<div class="current-file">Aktualny film:</div>';
            if (strpos($frame['video'], '.mp4') !== false || strpos($frame['video'], '.webm') !== false) {
                echo '<video controls style="max-width: 150px;"><source src="' . esc_url($frame['video']) . '"></video><br>';
            }
            echo '<small>' . esc_url($frame['video']) . '</small><br>';
        } else {
            echo '<div class="no-file">Brak filmu</div>';
        }
        echo '<div class="media-input-group">';
        echo '<input type="text" name="video_frame_' . $frame['num'] . '" value="' . esc_attr($frame['video']) . '" class="regular-text" placeholder="URL filmu" />';
        echo '<input type="button" class="button upload-button" value="Wybierz film" />';
        echo '</div>';
        echo '</div></td></tr>';
        
        // Start time
        echo '<tr><th><label>Czas startu (sekundy):</label></th><td>';
        echo '<input type="number" name="video_frame_' . $frame['num'] . '_start" value="' . esc_attr($frame['start']) . '" min="0" max="300" step="1" style="width: 80px;" />';
        echo '<p class="description">Czas w sekundach od którego film ma się rozpocząć</p>';
        echo '</td></tr>';
        
        // Fallback image
        echo '<tr><th><label>Obrazek zastępczy:</label></th><td>';
        echo '<div class="media-preview">';
        if ($frame['fallback']) {
            echo '<div class="current-file">Aktualny obrazek zastępczy:</div>';
            echo '<img src="' . esc_url($frame['fallback']) . '" alt="Obrazek zastępczy" style="max-width: 120px;"><br>';
            echo '<small>' . esc_url($frame['fallback']) . '</small><br>';
        } else {
            echo '<div class="no-file">Brak obrazka zastępczego</div>';
        }
        echo '<div class="media-input-group">';
        echo '<input type="text" name="video_frame_' . $frame['num'] . '_fallback" value="' . esc_attr($frame['fallback']) . '" class="regular-text" placeholder="URL obrazka zastępczego" />';
        echo '<input type="button" class="button upload-button" value="Wybierz obrazek" />';
        echo '</div>';
        echo '<p class="description">Obrazek pokazywany gdy film się nie załaduje</p>';
        echo '</div></td></tr>';
        
        echo '</table>';
        echo '</div>';
    }
    
    echo '</div>';
    
    // Gallery Tab
    echo '<div id="tab-gallery" class="fotobudka-tab-content">';
    echo '<h3>Galeria Zdjęć</h3>';
    echo '<p><em>Zdjęcia wyświetlane w karuzeli na stronie głównej. Możesz wybrać wiele zdjęć jednocześnie.</em></p>';
    
    echo '<div class="media-preview">';
    if ($gallery_images) {
        echo '<div class="current-file">Aktualne zdjęcia w galerii:</div>';
        echo '<div class="gallery-preview">';
        $images = explode(',', $gallery_images);
        foreach ($images as $img_url) {
            $img_url = trim($img_url);
            if ($img_url) {
                echo '<img src="' . esc_url($img_url) . '" alt="Zdjęcie galerii">';
            }
        }
        echo '</div>';
        echo '<small>URLs: ' . esc_html($gallery_images) . '</small><br><br>';
    } else {
        echo '<div class="no-file">Brak zdjęć w galerii</div><br>';
    }
    echo '<textarea name="gallery_images" class="large-text" rows="4" placeholder="URLs zdjęć oddzielone przecinkami lub wybierz przez przycisk poniżej">' . esc_textarea($gallery_images) . '</textarea>';
    echo '<br><br><input type="button" class="button upload-gallery-button button-primary" value="Wybierz zdjęcia dla galerii" />';
    echo '<p class="description"><strong>Instrukcja:</strong> Kliknij "Wybierz zdjęcia dla galerii", zaznacz kilka plików (Ctrl+klik), kliknij "Użyj tych plików"</p>';
    echo '</div>';
    
    echo '</div>';
    
    // Offer Cards Tab
    echo '<div id="tab-offers" class="fotobudka-tab-content">';
    echo '<h3>Tła Kart Ofert</h3>';
    echo '<p><em>Niestandardowe tła dla każdej karty oferty. Jeśli nie wybierzesz tła, używane będzie domyślne.</em></p>';
    
    $offers = [
        ['key' => '360', 'bg' => $offer_360_bg, 'name' => 'Fotobudka 360', 'default' => 'images/360.png'],
        ['key' => 'mirror', 'bg' => $offer_mirror_bg, 'name' => 'Fotolustro', 'default' => 'images/mirror.jpg'],
        ['key' => 'smoke', 'bg' => $offer_smoke_bg, 'name' => 'Ciężki dym', 'default' => 'images/heavysmoke.jpg'],
        ['key' => 'fountain', 'bg' => $offer_fountain_bg, 'name' => 'Fontanny iskier', 'default' => 'images/fountain.jpg'],
        ['key' => 'neons', 'bg' => $offer_neons_bg, 'name' => 'Neonowe napisy', 'default' => 'images/neons.jpg']
    ];
    
    foreach ($offers as $offer) {
        echo '<div class="offer-card-section">';
        echo '<div class="offer-card-title">' . $offer['name'] . '</div>';
        
        echo '<div class="media-preview">';
        if ($offer['bg']) {
            echo '<div class="current-file">Niestandardowe tło:</div>';
            echo '<img src="' . esc_url($offer['bg']) . '" alt="Tło ' . $offer['name'] . '" style="max-width: 150px;"><br>';
            echo '<small>' . esc_url($offer['bg']) . '</small><br>';
        } else {
            echo '<div class="no-file">Używane domyślne tło: ' . $offer['default'] . '</div>';
            echo '<img src="' . esc_url(get_template_directory_uri() . '/' . $offer['default']) . '" alt="Domyślne tło" style="max-width: 150px; opacity: 0.6;"><br>';
        }
        echo '<div class="media-input-group">';
        echo '<input type="text" name="offer_' . $offer['key'] . '_bg" value="' . esc_attr($offer['bg']) . '" class="regular-text" placeholder="URL niestandardowego tła" />';
        echo '<input type="button" class="button upload-button" value="Wybierz tło" />';
        if ($offer['bg']) {
            echo '<input type="button" class="button button-secondary reset-bg-button" data-field="offer_' . $offer['key'] . '_bg" value="Przywróć domyślne" />';
        }
        echo '</div>';
        echo '</div>';
        
        echo '</div>';
    }
    
    echo '</div>';
    
    // ENHANCED JAVASCRIPT WITH TABS
    ?>
    <script>
    jQuery(document).ready(function($) {
        // Tab functionality
        $('.fotobudka-tabs .nav-tab').click(function(e) {
            e.preventDefault();
            
            // Remove active class from all tabs and content
            $('.nav-tab').removeClass('nav-tab-active');
            $('.fotobudka-tab-content').removeClass('active');
            
            // Add active class to clicked tab
            $(this).addClass('nav-tab-active');
            
            // Show corresponding content
            var tabId = $(this).data('tab');
            $('#tab-' + tabId).addClass('active');
        });
        
        // Reset background button
        $('.reset-bg-button').click(function(e) {
            e.preventDefault();
            var fieldName = $(this).data('field');
            $('input[name="' + fieldName + '"]').val('');
            alert('Tło zostanie zresetowane do domyślnego po zapisaniu strony.');
        });
        
        // Single file upload button
        $('.upload-button').click(function(e) {
            e.preventDefault();
            var button = $(this);
            var input = button.prev('input[type="text"]');
            
            var media_uploader = wp.media({
                title: 'Wybierz plik',
                button: { text: 'Użyj tego pliku' },
                multiple: false
            });
            
            media_uploader.on('select', function() {
                var attachment = media_uploader.state().get('selection').first().toJSON();
                input.val(attachment.url);
                
                // Show success message
                button.after('<span class="upload-success" style="color: green; margin-left: 8px;">✓ Wybrano!</span>');
                setTimeout(function() {
                    $('.upload-success').fadeOut();
                }, 2000);
            });
            
            media_uploader.open();
        });
        
        // Multiple files gallery upload button  
        $('.upload-gallery-button').click(function(e) {
            e.preventDefault();
            var button = $(this);
            var textarea = $('textarea[name="gallery_images"]');
            
            var media_uploader = wp.media({
                title: 'Wybierz zdjęcia dla galerii',
                button: { text: 'Użyj tych plików' },
                multiple: true,
                library: { type: 'image' }
            });
            
            media_uploader.on('select', function() {
                var attachments = media_uploader.state().get('selection').toJSON();
                var urls = [];
                
                attachments.forEach(function(attachment) {
                    urls.push(attachment.url);
                });
                
                textarea.val(urls.join(', '));
                button.after('<span class="upload-success" style="color: green; margin-left: 8px;">✓ Wybrano ' + urls.length + ' zdjęć!</span>');
                setTimeout(function() {
                    $('.upload-success').fadeOut();
                }, 3000);
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
    
    // Existing fields
    if (isset($_POST['hero_image'])) {
        update_post_meta($post_id, '_fotobudka_hero_image', sanitize_text_field($_POST['hero_image']));
    }
    
    if (isset($_POST['hero_video'])) {
        update_post_meta($post_id, '_fotobudka_hero_video', sanitize_text_field($_POST['hero_video']));
    }
    
    if (isset($_POST['gallery_images'])) {
        update_post_meta($post_id, '_fotobudka_gallery_images', sanitize_textarea_field($_POST['gallery_images']));
    }
    
    // Video frame fields
    for ($i = 1; $i <= 4; $i++) {
        if (isset($_POST['video_frame_' . $i])) {
            update_post_meta($post_id, '_fotobudka_video_frame_' . $i, sanitize_text_field($_POST['video_frame_' . $i]));
        }
        if (isset($_POST['video_frame_' . $i . '_start'])) {
            $start_time = max(0, min(300, intval($_POST['video_frame_' . $i . '_start'])));
            update_post_meta($post_id, '_fotobudka_video_frame_' . $i . '_start', $start_time);
        }
        if (isset($_POST['video_frame_' . $i . '_fallback'])) {
            update_post_meta($post_id, '_fotobudka_video_frame_' . $i . '_fallback', sanitize_text_field($_POST['video_frame_' . $i . '_fallback']));
        }
    }
    
    // Offer card background fields
    $offer_keys = ['360', 'mirror', 'smoke', 'fountain', 'neons'];
    foreach ($offer_keys as $key) {
        if (isset($_POST['offer_' . $key . '_bg'])) {
            update_post_meta($post_id, '_fotobudka_offer_' . $key . '_bg', sanitize_text_field($_POST['offer_' . $key . '_bg']));
        }
    }
}
add_action('save_post', 'fotobudka_save_images');

// Generate dynamic CSS for offer card backgrounds
function fotobudka_dynamic_css() {
    if (is_front_page() || is_page_template('page-front.php')) {
        $post_id = get_queried_object_id();
        
        $css = '<style type="text/css">';
        
        $offers = [
            '360' => get_post_meta($post_id, '_fotobudka_offer_360_bg', true),
            'mirror' => get_post_meta($post_id, '_fotobudka_offer_mirror_bg', true),
            'smoke' => get_post_meta($post_id, '_fotobudka_offer_smoke_bg', true),
            'fountain' => get_post_meta($post_id, '_fotobudka_offer_fountain_bg', true),
            'neons' => get_post_meta($post_id, '_fotobudka_offer_neons_bg', true)
        ];
        
        foreach ($offers as $key => $bg_url) {
            if ($bg_url) {
                $css .= '.offer-card-' . $key . ' .card-background { background-image: url("' . esc_url($bg_url) . '"); }';
            }
        }
        
        $css .= '</style>';
        
        echo $css;
    }
}
add_action('wp_head', 'fotobudka_dynamic_css');

// Helper function to get video frame data
function get_fotobudka_video_frame($frame_number, $post_id = null) {
    if (!$post_id) {
        $post_id = get_queried_object_id();
    }
    
    $video_url = get_post_meta($post_id, '_fotobudka_video_frame_' . $frame_number, true);
    $start_time = get_post_meta($post_id, '_fotobudka_video_frame_' . $frame_number . '_start', true);
    $fallback_image = get_post_meta($post_id, '_fotobudka_video_frame_' . $frame_number . '_fallback', true);
    
    // Set defaults if not set
    if (!$start_time) {
        $defaults = [1 => 7, 2 => 3, 3 => 2, 4 => 4];
        $start_time = $defaults[$frame_number] ?? 0;
    }
    
    return [
        'video_url' => $video_url,
        'start_time' => $start_time,
        'fallback_image' => $fallback_image,
        'has_custom_video' => !empty($video_url)
    ];
}

// Helper function to get gallery images as array
function get_fotobudka_gallery_images($post_id = null) {
    if (!$post_id) {
        $post_id = get_queried_object_id();
    }
    
    $gallery_images = get_post_meta($post_id, '_fotobudka_gallery_images', true);
    
    if ($gallery_images) {
        $images = explode(',', $gallery_images);
        return array_map('trim', $images);
    }
    
    return [];
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