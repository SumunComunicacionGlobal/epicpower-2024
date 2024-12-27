<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
* Crear panel de opciones en el customizador
*/
function epicpower_new_customizer_settings($wp_customize) {
    // create settings section
    $wp_customize->add_panel('epicpower_opciones', array(
        'title'         => __( 'Opciones Epic Power', 'epicpower-admin' ),
        'description'   => __( 'Opciones para este sitio web', 'epicpower-admin' ),
        'priority'      => 1,
    ));
    $wp_customize->add_section('epicpower_redes_sociales', array(
        'title'         => __( 'Redes sociales', 'epicpower-admin' ),
        'priority'      => 20,
        'panel'         => 'epicpower_opciones',
    ));
    $wp_customize->add_section('epicpower_ajustes', array(
        'title'         => __( 'Ajustes Epic Power', 'epicpower-admin' ),
        'priority'      => 20,
        'panel'         => 'epicpower_opciones',
    ));
    $wp_customize->add_panel('epicpower_archive_pages_map', array(
        'title'         => __( 'Mapeo de páginas', 'epicpower-admin' ),
        'priority'      => 20,
    ));
    $wp_customize->add_section('epicpower_post_type_archive_pages_map', array(
        'title'         => __( 'Post type archives', 'epicpower-admin' ),
        'priority'      => 20,
        'panel'         => 'epicpower_archive_pages_map',
    ));



    $redes_sociales = array(
        'email',
        'whatsapp',
        'linkedin',
        'twitter',
        'facebook',
        'instagram',
        'youtube',
        'skype',
        'pinterest',
    );
    foreach ($redes_sociales as $red) {
        // add a setting
        $wp_customize->add_setting($red);
        
        // Add a control
        $wp_customize->add_control( $red,   array(
            'type'      => 'text',
            'label'     => 'URL ' . $red,
            'section'   => 'epicpower_redes_sociales',
        ) );
    }


    $wp_customize->add_setting('info_privacidad_formularios');
    $wp_customize->add_control( 'info_privacidad_formularios',   array(
        'type'      => 'textarea',
        'label'     => 'Información básica de privacidad para formularios',
        'description' => 'Esta información se puede reproducir en cualquier lugar con el shortcode [info_basica_privacidad].',
        'section'   => 'epicpower_ajustes',
    ) );

    $post_types = get_post_types( array(
        'public'        => true,
        '_builtin'      => false,
    ));

    foreach ($post_types as $post_type) {

        $wp_customize->add_setting( $post_type . '_archive_page_id', array(
          'capability' => 'edit_theme_options',
          'sanitize_callback' => 'sumun_sanitize_dropdown_pages',
        ) );
        $wp_customize->add_control( $post_type . '_archive_page_id', array(
          'type' => 'dropdown-pages',
          'section' => 'epicpower_post_type_archive_pages_map', // Add a default or your own section
          'label' => __( 'Página para el archivo del post_type ' . $post_type ),
          // 'description' => __( '' ),
        ) );

    }

    $taxonomies = get_taxonomies(array(
        'public'        => true,
        '_builtin'      => false,
    ));

    foreach ($taxonomies as $taxonomy) {

        $wp_customize->add_section('epicpower_'.$taxonomy.'_taxonomy_archive_pages_map', array(
            'title'         => __( $taxonomy . ' archives', 'epicpower-admin' ),
            'priority'      => 20,
            'panel'         => 'epicpower_archive_pages_map',
        ));

        $terms = get_terms( array( 'taxonomy' => $taxonomy, 'hide_empty' => false ) );
        foreach ($terms as $term) {

            $wp_customize->add_setting( $term->term_id . '_term_page_id', array(
              'capability' => 'edit_theme_options',
              'sanitize_callback' => 'sumun_sanitize_dropdown_pages',
            ) );
            $wp_customize->add_control( $term->term_id . '_term_page_id', array(
              'type' => 'dropdown-pages',
              'section' => 'epicpower_'.$taxonomy.'_taxonomy_archive_pages_map', // Add a default or your own section
              'label' => __( 'Página para el archivo del término ' . $term->name ),
              // 'description' => __( '' ),
            ) );

        }

    }

    $paginas = array(
        'descargas',
        'contacto',
    );
    foreach ($paginas as $pagina) {

        // add a setting
        $wp_customize->add_setting('id_pagina_' . $pagina);
        
        // Add a control
        $wp_customize->add_control( 'id_pagina_' . $pagina,   array(
            'type'      => 'number',
            'label'     => 'ID de la página de ' . $pagina,
            'section'   => 'epicpower_ajustes',
        ) );
    }

}
add_action('customize_register', 'epicpower_new_customizer_settings');

function sumun_sanitize_dropdown_pages( $page_id, $setting ) {
  // Ensure $input is an absolute integer.
  $page_id = absint( $page_id );

  // If $page_id is an ID of a published page, return it; otherwise, return the default.
  return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}
/***/
