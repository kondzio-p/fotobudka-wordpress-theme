<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#eec9d2">
    <link rel="icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/images/og-events-logo-prof.png">
    
    <?php wp_head(); ?>
    
    <!--Preload-->
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/images/360.png" as="image">
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/images/mirror.jpg" as="image">
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/images/heavysmoke.jpg" as="image">
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/images/fountain.jpg" as="image">
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/images/neons.jpg" as="image">
</head>
<body <?php body_class(); ?>>

<!-- Dodaj ten div jako pierwsze dziecko body -->
<div id="background-fixed"></div>

<header class="header">
    <div class="nav-container">
        <!-- Na desktop: normalny układ -->
        <div class="logo d-none d-md-block">
            <img
                src="<?php echo get_template_directory_uri(); ?>/images/og-events-logo-white.png"
                alt="OG Events Logo"
                onerror="this.outerHTML='<div style=\'color: #8b4b7a; font-weight: bold; font-size: 24px;\'>OG<br><span style=\'font-size: 12px; font-weight: normal;\'>EVENT SPOT</span></div>'"
            />
        </div>

        <nav class="d-none d-md-block">
            <ul class="nav-menu">
                <li>
                    <a href="<?php echo home_url(); ?>" class="<?php echo is_front_page() ? 'active' : ''; ?>">Strona główna</a>
                </li>
                <li><a href="#welcome">O nas</a></li>
                <li><a href="#contact">Kontakt</a></li>
            </ul>
        </nav>

        <div class="social-icons d-none d-md-flex">
            <a
                href="<?php echo get_acf_value('facebook_url', 'https://www.facebook.com/profile.php?id=61553668165091'); ?>"
                target="_blank"
                class="social-icon facebook"
                aria-label="Facebook"
            ><img src="<?php echo get_template_directory_uri(); ?>/images/fb.svg" width="20px" alt="" /></a>
            <a
                href="<?php echo get_acf_value('instagram_url', 'https://www.instagram.com/og.eventspot/'); ?>"
                target="_blank"
                class="social-icon instagram"
                aria-label="Instagram"
            ><img src="<?php echo get_template_directory_uri(); ?>/images/insta.svg" width="25px" alt="" /></a>
        </div>

        <!-- Na mobile: kompaktowy układ -->
        <div class="d-md-none w-100">
            <!-- Logo i ikony w jednej linii -->
            <div class="header-top-row">
                <div class="logo">
                    <img
                        src="<?php echo get_template_directory_uri(); ?>/images/og-events-logo-white.png"
                        alt="OG Events Logo"
                        onerror="this.outerHTML='<div style=\'color: #8b4b7a; font-weight: bold; font-size: 18px;\'>OG<br><span style=\'font-size: 10px; font-weight: normal;\'>EVENT SPOT</span></div>'"
                    />
                </div>

                <div class="social-icons">
                    <a
                        href="<?php echo get_acf_value('facebook_url', 'https://www.facebook.com/profile.php?id=61553668165091'); ?>"
                        target="_blank"
                        class="social-icon facebook"
                        aria-label="Facebook"
                    ><img src="<?php echo get_template_directory_uri(); ?>/images/fb.svg" width="16px" alt="" /></a>
                    <a
                        href="<?php echo get_acf_value('instagram_url', 'https://www.instagram.com/og.eventspot/'); ?>"
                        target="_blank"
                        class="social-icon instagram"
                        aria-label="Instagram"
                    ><img src="<?php echo get_template_directory_uri(); ?>/images/insta.svg" width="18px" alt="" /></a>
                </div>
            </div>

            <!-- Menu pod spodem -->
            <nav>
                <ul class="nav-menu">
                    <li>
                        <a href="<?php echo home_url(); ?>" class="<?php echo is_front_page() ? 'active' : ''; ?>">Główna</a>
                    </li>
                    <li><a href="#welcome">O nas</a></li>
                    <li><a href="#contact">Kontakt</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>
