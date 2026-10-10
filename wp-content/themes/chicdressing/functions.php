<?php 

add_action( 'wp_enqueue_scripts', 'chicdressing_enqueue_styles' );
function chicdressing_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' ); 
}

add_filter( 'big_image_size_threshold', '__return_false' );

// Désactive Open Sans chargé depuis Google Fonts par le thème Ashe
function chicdressing_remove_google_opensans() {
    wp_dequeue_style( 'ashe-opensans-font' );
    wp_deregister_style( 'ashe-opensans-font' );

    wp_dequeue_style( 'ashe-kalam-font' );
    wp_deregister_style( 'ashe-kalam-font' );

    wp_dequeue_style( 'ashe-playfair-font' );
    wp_deregister_style( 'ashe-playfair-font' );
}

add_action( 'wp_enqueue_scripts', 'chicdressing_remove_google_opensans', 20 );


 // Améliore l'accessibilité du formulaire de recherche
function chicdressing_accessible_search_form( $form ) {
    $form = str_replace(
        'type="search" name="s" id="s"',
        'type="search" name="s" id="s" aria-label="Rechercher"',
        $form
    );

    return $form;
}
add_filter( 'get_search_form', 'chicdressing_accessible_search_form', 20 );

// Améliore l'accessibilité du champ anti-spam MailPoet
function chicdressing_accessible_mailpoet_antispam() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const field = document.querySelector('input[name="wysija[user][abs][email]"]');

        if (field) {
            field.setAttribute('aria-label', 'Champ anti-spam');
        }
    });
    </script>
    <?php
}
add_action( 'wp_footer', 'chicdressing_accessible_mailpoet_antispam', 100 );

// Corrige les références ARIA cassées générées par le slider Slick
function chicdressing_fix_slider_aria() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('#featured-slider [aria-describedby]').forEach(function (slide) {
            const targetId = slide.getAttribute('aria-describedby');

            if (targetId && !document.getElementById(targetId)) {
                slide.removeAttribute('aria-describedby');
            }
        });
    });
    </script>
    <?php
}
add_action( 'wp_footer', 'chicdressing_fix_slider_aria', 110 );