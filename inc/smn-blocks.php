<?php 

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


if ( function_exists( 'register_block_style' ) ) {

    register_block_style(
        'core/cover',
        array(
            'name'         => 'image-header',
            'label'        => __( 'Cabecera', 'smn-admin' ),
            'is_default'   => false,
        )
    );
    
    register_block_style(
        'core/cover',
        array(
            'name'         => 'stretched-block',
            'label'        => __( 'Stretched link', 'smn-admin' ),
            'is_default'   => false,
        )
    );
    
    register_block_style(
        'core/button',
        array(
            'name'         => 'arrow-link',
            'label'        => __( 'Con flecha', 'smn-admin' ),
            'is_default'   => false,
        )
    );

    register_block_style(
        'core/columns',
        array(
            'name'         => 'gapless',
            'label'        => __( 'Sin espacio', 'smn-admin' ),
            'is_default'   => false,
        )
    );

    register_block_style(
        'core/list',
        array(
            'name'         => 'list-unstyled',
            'label'        => __( 'Sin viñetas', 'smn-admin' ),
            'is_default'   => false,
        )
    );
       
    $display_text_block_types = array(
        'core/paragraph',
        'core/heading',
    );

    foreach( $display_text_block_types as $block_type ) {

        for ($i=1; $i <= 6; $i++) { 

            register_block_style(
                $block_type,
                array(
                    'name'         => 'h' . $i,
                    'label'        => sprintf( __( 'Imita un h%s', 'smn-admin' ), $i ),
                    'is_default'   => false,
                )
            );

        }
            
        for ($i=1; $i <= 4; $i++) { 

            register_block_style(
                $block_type,
                array(
                    'name'         => 'display-' . $i,
                    'label'        => sprintf( __( 'Display %s', 'smn-admin' ), $i ),
                    'is_default'   => false,
                )
            );

        }

        register_block_style(
            $block_type,
            array(
                'name'         => 'supratitle',
                'label'        => __( 'Supra título', 'smn-admin' ),
                'is_default'   => false,
            )
        );
            
    }

    register_block_style(
        'core/praragrap',
        array(
            'name'         => 'cifra-circulo',
            'label'        => __( 'Cifra círculo', 'smn-admin' ),
            'is_default'   => false,
        )
    );

    $carousel_block_types = array(
        'core/group',
        'core/gallery',
    );

    foreach( $carousel_block_types as $block_type ) {

        register_block_style(
            $block_type,
            array(
                'name'         => 'slick-carousel',
                'label'        => sprintf( __( 'Carrusel', 'smn-admin' ) ),
                'is_default'   => false,
            )
        );

        register_block_style(
            $block_type,
            array(
                'name'         => 'slick-carousel-logos',
                'label'        => __( 'Carrusel Logos', 'smn-admin' ),
                'is_default'   => false,
            )
        );

    }
            

}

add_filter( 'render_block', 'remove_is_style_prefix', 10, 2 );
function remove_is_style_prefix( $block_content, $block ) {

    if ( isset( $block['attrs']['className'] ) ) {
    
        $components = array(
            'h1',
            'h2',
            'h3',
            'h4',
            'h5',
            'h6',
            'display-1',
            'display-2',
            'display-3',
            'display-4',
            'lead',
            'list-unstyled',
        );

        $prefixed_components = array();
    
        foreach ( $components as $component ) {
            $prefixed_components[] = 'is-style-' . $component;
        }

        $block_content = str_replace(
            $prefixed_components,
            $components,
            $block_content
        );

    }
    
    return $block_content;
}

// add_action( 'init', 'register_acf_blocks' );
function register_acf_blocks() {
    register_block_type( get_stylesheet_directory() . '/block-templates/timeline' );
}

add_filter( 'render_block', 'list_block_wrapper', 10, 2 );
function list_block_wrapper( $block_content, $block ) {
    if ( $block['blockName'] === 'core/list' ) {
        $block_content = str_replace( 
            array( '<ul class="', '<ol class="'), 
            array( '<ul class="wp-block-list ', '<ol class="wp-block-list '), $block_content );
        
        $block_content = str_replace( 
            array( '<ul>', '<ol>'), 
            array( '<ul class="wp-block-list">', '<ol class="wp-block-list">'), $block_content );
    }
    return $block_content;
}

function sumun_block_categories( $categories, $post ) {

    return array_merge(
        array(
            array(
                'slug' => 'epic-power-contenido',
                'title' => __( 'Epic Power - Bloques de contenido', 'epicpower-admin' ),
                // 'icon'  => 'plus-alt',
            ),
            array(
                'slug' => 'epic-power-elementos',
                'title' => __( 'Epic Power - Elementos simples', 'epicpower-admin' ),
                // 'icon'  => 'plus-alt',
            ),
        ),
        $categories
    );
}
add_filter( 'block_categories', 'sumun_block_categories', 10, 2 );

function sumun_nocookie_youtube_block( $block_content, $block ) {

    $aviso = '<p class="small text-muted">' . __( 'Al reproducir el vídeo aceptas la <a href="https://policies.google.com/technologies/cookies?hl=es" target="_blank" rel="nofollow">política de cookies y de privacidad de Google</a>.', 'epicpower' ) . '</p>';
    if ( function_exists( 'gdpr_cookie_is_accepted' ) ) {
        if ( gdpr_cookie_is_accepted( 'thirdparty' ) ) {
            $aviso = '';
        }
    }

    if ( $block['blockName'] === 'core-embed/youtube' ) {
        $block_content = str_replace('www.youtube.com', 'www.youtube-nocookie.com', $block_content);
        $block_content .= $aviso;
    }
    if ( $block['blockName'] === 'acf/video-emergente' ) {
        $block_content .= $aviso;
    }
    return $block_content;
}
 
add_filter( 'render_block', 'sumun_nocookie_youtube_block', 10, 2 );

add_action('acf/init', 'epicpower_init_block_types');
function epicpower_init_block_types() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // register a block.
        acf_register_block_type(array(
            'name'              => 'related-content-title',
            'title'             => __('Título destacado', 'epicpower-admin'),
            'description'       => __('Muestra un título destacado con borde y flecha pixelada hacia abajo'),
            'render_template'   => 'loop-templates/blocks/related-content-title.php',
            'category'          => 'epic-power-elementos',
            'icon'              => 'arrow-down',
            'keywords'          => array( 'encabezado', 'titulo' ),
            // 'mode'              => 'edit',
        ));

        // register a block.
        acf_register_block_type(array(
            'name'              => 'link-plus-block',
            'title'             => __('Enlace con icono +', 'epicpower-admin'),
            'description'       => __('Muestra un enlace destacado con un icono +'),
            'render_template'   => 'loop-templates/blocks/link-plus-block.php',
            'category'          => 'epic-power-elementos',
            'icon'              => 'plus-alt',
            'keywords'          => array( 'link', 'enlace' ),
            // 'mode'              => 'edit',
        ));

        // register a block.
        acf_register_block_type(array(
            'name'              => 'link-flecha-derecha',
            'title'             => __('Enlace con flecha derecha', 'epicpower-admin'),
            'description'       => __('Enlace con flecha hacia la derecha (tipo Leer Más)'),
            'render_template'   => 'loop-templates/blocks/link-flecha-derecha.php',
            'category'          => 'epic-power-elementos',
            'icon'              => 'arrow-right-alt',
            'keywords'          => array( 'link', 'enlace' ),
            // 'mode'              => 'edit',
        ));





        // register a block.
        acf_register_block_type(array(
            'name'              => 'featured-link-block',
            'title'             => __('Enlace destacado con color de fondo', 'epicpower-admin'),
            'description'       => __('Muestra un bloque con color de fondo, título, contenido y enlace'),
            'render_template'   => 'loop-templates/blocks/featured-link-block.php',
            'category'          => 'epic-power-contenido',
            'icon'              => 'plus-alt',
            'keywords'          => array( 'link', 'enlace' ),
        ));

        // register a block.
        acf_register_block_type(array(
            'name'              => 'enlace-con-titulo-y-texto',
            'title'             => __('Enlace con titulo y texto', 'epicpower-admin'),
            'description'       => __('Muestra un enlace con título, texto y botón'),
            'render_template'   => 'loop-templates/blocks/enlace-con-titulo-y-texto.php',
            'category'          => 'epic-power-contenido',
            'icon'              => 'editor-alignleft',
            'keywords'          => array( 'link', 'enlace', 'paginas' ),
            // 'mode'              => 'edit',
            // 'supports'          => array(
            //                             'mode'      => false,
            //                         ),
        ));

        // register a block.
        acf_register_block_type(array(
            'name'              => 'enlace-con-foto-y-texto',
            'title'             => __('Enlace con foto y texto', 'epicpower-admin'),
            'description'       => __('Muestra un enlace con foto, título, texto y botón'),
            'render_template'   => 'loop-templates/blocks/enlace-con-foto-y-texto.php',
            'category'          => 'epic-power-contenido',
            'icon'              => 'align-full-width',
            'keywords'          => array( 'link', 'enlace', 'paginas' ),
            // 'mode'              => 'edit',
            // 'supports'          => array(
            //                             'mode'      => false,
            //                         ),
        ));

        // register a block.
        acf_register_block_type(array(
            'name'              => 'enlaces-paginas',
            'title'             => __('Enlace a páginas', 'epicpower-admin'),
            'description'       => __('Muestra enlaces a páginas y obtiene la imagen destacada, el título y el extracto de forma automática'),
            'render_template'   => 'loop-templates/blocks/enlaces-paginas.php',
            'category'          => 'epic-power-contenido',
            'icon'              => 'table-row-before',
            'keywords'          => array( 'link', 'enlace', 'paginas' ),
            'mode'              => 'edit',
            'supports'          => array(
                                        'mode'      => false,
                                    ),
        ));

        // Register a block.
        acf_register_block_type(array(
            'name'              => 'products',
            'title'             => __('Listado de productos'),
            'description'       => __('Inserta productos con miniatura.'),
            'render_template'   => 'loop-templates/blocks/products.php',
            'category'          => 'epic-power-contenido',
            'icon'              => 'admin-plugins',
            'keywords'          => array('product', 'insert', 'categoría'),
            'mode'              => 'edit',
            'supports'          => array(
                                        'mode'      => false,
                                    ),
        ));

        // register a block.
        acf_register_block_type(array(
            'name'              => 'team',
            'title'             => __('Equipo', 'epicpower-admin'),
            'description'       => __('Muestra a los miembros del equipo'),
            'render_template'   => 'loop-templates/blocks/team.php',
            'category'          => 'epic-power-contenido',
            'icon'              => 'id',
            'keywords'          => array( 'team', 'equipo', 'persona', 'people' ),
            'mode'              => 'edit',
            'supports'          => array(
                                        'mode'      => false,
                                    ),
        ));

        // register a block.
        acf_register_block_type(array(
            'name'              => 'pages-carousel',
            'title'             => __('Carrusel de páginas', 'epicpower-admin'),
            'description'       => __('Muestra un carrusel con enlaces a páginas'),
            'render_template'   => 'loop-templates/blocks/pages-carousel.php',
            'category'          => 'epic-power-contenido',
            'icon'              => 'slides',
            'keywords'          => array('carrusel', 'enlace', 'paginas'),
            'mode'              => 'edit',
            'supports'          => array(
                                        'mode'      => false,
                                    ),
        ));


    }
}

add_filter('acf/load_field/name=categoria_de_productos', 'acf_load_categoria_de_productos_choices');
function acf_load_categoria_de_productos_choices( $field ) {
    
    // reset choices
    $field['choices'] = array();
    
    $terms = get_terms( array(
        'taxonomy'      => 'product_category',
        'hide_empty'    => 0
    ));
    
    // loop through array and add to field 'choices'
    if( !empty($terms) ) {
        
        foreach( $terms as $term ) {
            
            $field['choices'][ $term->term_id ] = $term->name;
            
        }
        
    }
    

    // return the field
    return $field;
    
}

// add_filter( 'render_block', 'sumun_bootstrap_buttons', 10, 2 );
// function sumun_bootstrap_buttons( $block_content, $block ) {
//     if ( $block['blockName'] !== 'core/button' ) return $block_content;

//     $block_content = str_replace( 'wp-block-button__link', 'wp-block-button__link btn', $block_content);

//     if ( isset( $block['attrs']['backgroundColor'] ) ) return $block_content;

//     if ( isset( $block['attrs']['className'] ) && strpos( $block['attrs']['className'], 'is-style-outline') !== false ) {
//         $block_content = str_replace( 'is-style-outline', '', $block_content);
//         $block_content = str_replace( 'wp-block-button__link btn', 'wp-block-button__link btn btn-outline-primary shadow', $block_content);
//         return $block_content;
//     }



//     $block_content = str_replace( 'wp-block-button__link btn', 'wp-block-button__link btn btn-primary', $block_content);
//     return $block_content;

// }


// add_filter( 'render_block', 'sumun_animaciones_bloques', 10, 2 );
function sumun_animaciones_bloques( $block_content, $block ) {

    if( 'slide' == get_post_type() ) return $block_content;

    if ( $block['blockName'] == 'core/column' ) {

            $block_content = str_replace(
                array( 
                    'wp-block-column"', 
                    'wp-block-column ', 
                ),
                array( 
                    'wp-block-column ' . ANIMATION_CLASS . '"', 
                    'wp-block-column ' . ANIMATION_CLASS . ' ',
                ),

                $block_content);

    } elseif( $block['blockName'] == 'core/cover' ) {

        $block_content = str_replace( 'wp-block-cover__inner-container', 'wp-block-cover__inner-container '. ANIMATION_CLASS, $block_content);

    } elseif( $block['blockName'] == 'core/media-text' ) {

        $block_content = str_replace( 'wp-block-media-text__media', 'wp-block-media-text__media '. ANIMATION_CLASS, $block_content);

    } elseif( $block['blockName'] == 'core/buttons' ) {

        $block_content = str_replace( 'wp-block-buttons', 'wp-block-buttons '. ANIMATION_CLASS, $block_content);

    } elseif( $block['blockName'] == 'core/image' ) {

        $block_content = str_replace( 'wp-block-image', 'wp-block-image '. ANIMATION_CLASS, $block_content);

    } elseif ( 
        $block['blockName'] == 'core/heading' ||
        $block['blockName'] == 'core/paragraph'
    ) {

        if( stripos( $block_content, 'class="' ) !== false ) {

            $block_content = str_replace('class="', 'class="'. ANIMATION_CLASS . ' ', $block_content);

        } else {

            $block_content = str_replace(
                array(
                    // '<p',
                    '<h1',
                    '<h2',
                    '<h3',
                    '<h4',
                    '<h5',
                    '<h6',
                ), 
                array(
                    // '<p class="'. ANIMATION_CLASS . '"',
                    '<h1 class="'. ANIMATION_CLASS . '"',
                    '<h2 class="'. ANIMATION_CLASS . '"',
                    '<h3 class="'. ANIMATION_CLASS . '"',
                    '<h4 class="'. ANIMATION_CLASS . '"',
                    '<h5 class="'. ANIMATION_CLASS . '"',
                    '<h6 class="'. ANIMATION_CLASS . '"',
                ),

                $block_content
            );

        }

    }

    return $block_content;

}

add_filter( 'render_block', 'append_breadcrumb_to_cover', 10, 2 );
function append_breadcrumb_to_cover( $block_content, $block ) {

    if ( 
        ( $block['blockName'] === 'nk/awb' ) ||
        (   $block['blockName'] === 'core/cover' && 
            isset( $block['attrs']['className'] ) && 
            strpos( $block['attrs']['className'], 'is-style-image-header' ) !== false 
        )
    ) {
        $block_content .= smn_get_breadcrumb();
    }

    return $block_content;
}

 // animated fadeInUp duration2 eds-on-scroll