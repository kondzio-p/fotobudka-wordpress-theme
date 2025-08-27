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
