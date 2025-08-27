<!-- Sekcja Footer: Kontakt i prawa autorskie -->
<footer
    class="contact-footer"
    style="
        background: #eec9d2;
        padding: 60px 0 40px 0;
        position: relative;
        margin-top: 0;
    "
    id="contact"
>
    <div class="container">
        <div class="row">
            
            <!-- Kolumna: Informacje kontaktowe -->
            <div class="col-lg-8">
                <h3
                    style="
                        color: #801039;
                        font-weight: bold;
                        font-size: 42px;
                        margin-bottom: 40px;
                        line-height: 1.2;
                    "
                >
                    <?php echo get_acf_value('footer_tytul', 'Dotrzyj do nas za pomocą'); ?>
                </h3>

                <div class="contact-info">
                    
                    <!-- Kontakt: Facebook -->
                    <div
                        class="contact-item"
                        style="
                            display: flex;
                            align-items: center;
                            margin-bottom: 25px;
                            font-size: 24px;
                            color: #2c2c2c;
                        "
                    >
                        <div
                            style="
                                width: 40px;
                                height: 40px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                margin-right: 20px;
                            "
                        >
                            <img
                                src="<?php echo get_template_directory_uri(); ?>/images/fb.svg"
                                alt="Facebook"
                                style="width: 32px; height: 32px"
                            />
                        </div>
                        <a
                            href="<?php echo get_acf_value('facebook_url', 'https://www.facebook.com/profile.php?id=61553668165091'); ?>"
                            target="_blank"
                            style="
                                font-weight: 500;
                                color: #2c2c2c;
                                text-decoration: none;
                            "
                            onmouseover="this.style.color='#801039'"
                            onmouseout="this.style.color='#2c2c2c'"
                        ><?php echo get_acf_value('facebook_handle', '@OG Eventspot'); ?></a>
                    </div>

                    <!-- Kontakt: Instagram -->
                    <div
                        class="contact-item"
                        style="
                            display: flex;
                            align-items: center;
                            margin-bottom: 25px;
                            font-size: 24px;
                            color: #2c2c2c;
                        "
                    >
                        <div
                            style="
                                width: 40px;
                                height: 40px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                margin-right: 20px;
                            "
                        >
                            <img
                                src="<?php echo get_template_directory_uri(); ?>/images/insta.svg"
                                alt="Instagram"
                                style="width: 32px; height: 32px"
                            />
                        </div>
                        <a
                            href="<?php echo get_acf_value('instagram_url', 'https://www.instagram.com/og.eventspot/'); ?>"
                            target="_blank"
                            style="
                                font-weight: 500;
                                color: #2c2c2c;
                                text-decoration: none;
                            "
                            onmouseover="this.style.color='#801039'"
                            onmouseout="this.style.color='#2c2c2c'"
                        ><?php echo get_acf_value('instagram_handle', '@og.eventspot'); ?></a>
                    </div>

                    <!-- Kontakt: Telefon -->
                    <div
                        class="contact-item"
                        style="
                            display: flex;
                            align-items: center;
                            margin-bottom: 25px;
                            font-size: 24px;
                            color: #2c2c2c;
                        "
                    >
                        <div
                            style="
                                width: 40px;
                                height: 40px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                margin-right: 20px;
                            "
                        >
                            <img
                                src="<?php echo get_template_directory_uri(); ?>/images/phone.svg"
                                alt="Phone"
                                style="width: 32px; height: 32px"
                            />
                        </div>
                        <a
                            href="tel:<?php echo str_replace(' ', '', get_acf_value('telefon', '727323442')); ?>"
                            style="
                                font-weight: 500;
                                color: #2c2c2c;
                                text-decoration: none;
                            "
                            onmouseover="this.style.color='#801039'"
                            onmouseout="this.style.color='#2c2c2c'"
                        ><?php echo get_acf_value('telefon', '727 323 442'); ?></a>
                    </div>
                </div>
            </div>

            <!-- Kolumna: Prawa autorskie -->
            <div class="col-lg-4 d-flex align-items-end justify-content-end">
                <div
                    style="
                        text-align: right;
                        color: #666;
                        font-size: 14px;
                        font-weight: 400;
                    "
                >
                    © <?php echo date('Y'); ?> - Wszelkie prawa zastrzeżone
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Animacje GSAP -->
<script>
    gsap.registerPlugin(ScrollTrigger);
</script>

<?php wp_footer(); ?>
</body>
</html>
