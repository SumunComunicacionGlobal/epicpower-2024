<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

define( 'NEW_HEADER', true );

// define( 'COL_CLASSES', 'col-sm-6 col-lg-4 col-xl-3 mb-4 stretch-linked-block' );
define( 'COL_CLASSES', '' );
define('ANIMATION_CLASS', 'animated fadeInUp duration2 eds-on-scroll eds-animation-paused');
define('DOWNLOADS_ID', get_theme_mod( 'id_pagina_descargas', 1231 ) );
define('CONTACT_ID', get_theme_mod( 'id_pagina_contacto', 1235 ) );
define('ACADEMY_ID', get_theme_mod( 'id_pagina_academy', 16586 ) );
define('DATOS_TECNICOS_ID', get_theme_mod( 'id_datos_tecnicos', 'group_5eeb30fcf1cb7' ) );
define('APPLICATION_NOTES_TERM_ID', get_theme_mod( 'id_application_notes', 31 ) );

$content_width = 1140;
add_theme_support('editor-styles');
add_filter( 'widget_text', 'do_shortcode');
add_filter( 'wpcf7_form_elements', 'do_shortcode' );

function understrap_wpdocs_theme_add_editor_styles() {
    add_editor_style( 'css/custom-editor-style.css' );
}

// UnderStrap's includes directory.
$understrap_inc_dir = 'inc';

// Array of files to include.
$understrap_includes = array(
    // '/smn-dummy-content.php',
    '/smn-security.php',
    '/smn-seo.php',
    '/smn-widgets.php',
    '/smn-post-types.php',
    '/smn-setup.php',
    '/smn-hooks.php',
    '/smn-customizer.php',
    '/smn-template-tags.php',
    '/smn-shortcodes.php',
    '/smn-blocks.php',
);

$epicpower_includes = array(
    // '/seo.php',
    // '/post-types.php',
    // '/shortcodes.php',
    // '/customizer-epicpower.php',
    // '/gdpr-cookies.php',
    // '/widgets-epicpower.php',
    // '/blocks-epicpower.php',
    // '/dummy-content.php',
);


// Load WooCommerce functions if WooCommerce is activated.
if ( class_exists( 'WooCommerce' ) ) {
    $understrap_includes[] = '/smn-woocommerce.php';
}

if ( class_exists('ACF')) {
    $understrap_includes[] = '/smn-acf.php';
}

if ( class_exists('FacetWP') ) {
    $understrap_includes[] = '/smn-facetwp.php';
}

if ( function_exists( 'gdpr_cookie_is_accepted' ) ) {
    $understrap_includes[] = '/smn-moove-gdpr-cookies.php';
}

// Include files.
foreach ( $understrap_includes as $file ) {
    require_once get_theme_file_path( $understrap_inc_dir . $file );
}

/**
 * Removes the parent themes stylesheet and scripts from inc/enqueue.php
 */
function understrap_remove_scripts() {
	wp_dequeue_style( 'understrap-styles' );
	wp_deregister_style( 'understrap-styles' );

	wp_dequeue_script( 'understrap-scripts' );
	wp_deregister_script( 'understrap-scripts' );
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );



/**
 * Enqueue our stylesheet and javascript file
 */
function theme_enqueue_styles() {

	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap' );

	wp_enqueue_style( 'slick', get_stylesheet_directory_uri() . '/js/slick/slick.css' );
    wp_enqueue_style( 'slick-theme', get_stylesheet_directory_uri() . '/js/slick/slick-theme.css' );

    wp_enqueue_style( 'wp-block-cover' );

	// Get the theme data.
	$the_theme     = wp_get_theme();
	$theme_version = $the_theme->get( 'Version' );

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	// Grab asset urls.
	$theme_styles  = "/css/child-theme{$suffix}.css";
	$theme_scripts = "/js/child-theme{$suffix}.js";
	
	$css_version = $theme_version . '.' . filemtime( get_stylesheet_directory() . $theme_styles );

	wp_enqueue_style( 'epicpower-styles', get_stylesheet_directory_uri() . $theme_styles, array(), $css_version );
	wp_enqueue_script( 'jquery' );

	wp_enqueue_script( 'slick', get_stylesheet_directory_uri() . '/js/slick/slick.min.js', null, null, true );

	$js_version = $theme_version . '.' . filemtime( get_stylesheet_directory() . $theme_scripts );
	
	wp_enqueue_script( 'epicpower-scripts', get_stylesheet_directory_uri() . $theme_scripts, array(), $js_version, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'sticky-sidebar', get_stylesheet_directory_uri() . '/js/jquery.sticky-sidebar.min.js', array(), false, true );

}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );



/**
 * Load the child theme's text domain
 */
function add_child_theme_textdomain() {
	load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
	load_child_theme_textdomain( 'epicpower', get_stylesheet_directory() . '/languages' );
	load_child_theme_textdomain( 'smn', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );



/**
 * Overrides the theme_mod to default to Bootstrap 5
 *
 * This function uses the `theme_mod_{$name}` hook and
 * can be duplicated to override other theme settings.
 *
 * @return string
 */
function understrap_default_bootstrap_version() {
	return 'bootstrap5';
}
add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_default_bootstrap_version', 20 );



/**
 * Loads javascript for showing customizer warning dialog.
 */
function understrap_child_customize_controls_js() {
	wp_enqueue_script(
		'understrap_child_customizer',
		get_stylesheet_directory_uri() . '/js/customizer-controls.js',
		array( 'customize-preview' ),
		'20130508',
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'understrap_child_customize_controls_js' );


if( !function_exists( 'epicpower_unregister_post_type' ) ) {
    function epicpower_unregister_post_type(){
        unregister_post_type( 'rl_gallery' );
    }
}
add_action('init','epicpower_unregister_post_type');



function mg_add_async_defer_attributes( $tag, $handle ) {

    // Busco el valor "async"
    if( strpos( $handle, "async" ) ):
        $tag = str_replace(' src', ' async="async" src', $tag);
    endif;

    // Busco el valor "defer"
    if( strpos( $handle, "defer" ) ):
        $tag = str_replace(' src', ' defer="defer" src', $tag);
    endif;

    return $tag;
}
add_filter('script_loader_tag', 'mg_add_async_defer_attributes', 10, 2);

function author_page_redirect() {
    if ( is_author() ) {
        wp_redirect( home_url() );
    }
}
add_action( 'template_redirect', 'author_page_redirect' );

add_action( 'template_redirect', 'post_redirect' );
function post_redirect() {
    if (!is_singular()) return;

    $url = get_post_meta( get_the_ID(), 'redireccionar', true );
    if ( $url ) {
        wp_redirect( $url );
        die;
    }
     
}

// add_filter('the_content', 'mostrar_sidebar_producto', 70, 1);
function mostrar_sidebar_producto($content) {
    if (is_singular()) {
        $mostrar_footer_producto = get_post_meta( get_the_ID(), 'mostrar_footer_producto', true );
        if (is_singular( 'product' ) || $mostrar_footer_producto) {
            ob_start();
            dynamic_sidebar( 'footer-product' );
            $r = ob_get_clean();
            if ($r) {
                $r = '<div id="wrapper-footer-product" class="'.ANIMATION_CLASS.'"><div class="row">'.$r.'</div></div>';
            }
            $content = $content . $r;
        }
    }

    return $content;
}

add_filter('the_content', 'mostrar_case_studies', 10, 1);
function mostrar_case_studies($content) {

    if(has_shortcode( $content, 'contenido_pagina' )) return $content;

    if (is_page() || is_singular('product') ) {

        $post_type = 'case_study';
        // $tax = 'industry';
        $taxes = array( 'industry', 'product_category' );
        $r = '';
        $terms = wp_get_object_terms( get_the_ID(), $taxes, array('fields' => 'ids') );

        if (!empty($terms)) {

            $qargs = array(
                    'post_type'         => $post_type,
                    'posts_per_page'    => -1,
                );
            // $qargs['tax_query'] = array(
            //                             array(
            //                                 'taxonomy'      => $tax,
            //                                 'terms'         => $terms,
            //                                 ),
            //         );

            $query = new WP_Query($qargs);

            $enabled_content = '';
            $disabled_content = '';

            if ($query->have_posts()) {

                $post_type_object = get_post_type_object( $post_type );
                $r .= '<div class="wrapper related-content" id="'.$post_type.'">';
                    $r .= '<h3 class="related-content-title">'. $post_type_object->labels->name .'</h3>';
       
                        $r .= '<div class="row filtrable '.$post_type.'">';
                            while ($query->have_posts()) { $query->the_post();
                                $disabled_class = 'disabled';
                                foreach ($taxes as $tax) {
                                    if ( has_term($terms, $tax) ) $disabled_class = '';
                                }


                                // $disabled_class = ( has_term( $terms ) ) ? '' : 'disabled';
                                $case_study_content = '';
                                $case_study_content .= '<div class="col-md-6 col-lg-4 mb-4 '.$disabled_class.'">';
                                    ob_start();

                                        get_template_part( 'loop-templates/content', $post_type );

                                    $case_study_content .= ob_get_clean();
                                $case_study_content .= '</div>';

                                if ( $disabled_class ) {
                                    $disabled_content .= $case_study_content;
                                } else {
                                    $enabled_content .= $case_study_content;
                                }
                            }

                            $r .= $enabled_content . $disabled_content;

                        $r .= '</div>';

                $r .= '</div>';
            }
            wp_reset_postdata();

        }

        return $content . $r;
    }
    return $content;
}

add_filter('the_content', 'mostrar_descargas', 50, 1);
function mostrar_descargas($content) {
    $current_post_type = get_post_type();
    if (is_singular() && 'sdm_downloads' != $current_post_type ) {
        $array_contenido_relacionado = array(
            // 'product'           => 'product_category',
            // 'case_study'        => 'product_category',
            'sdm_downloads'     => 'product_category',
        );

        $r = '';

        foreach ($array_contenido_relacionado as $post_type => $tax) {

            $anchor = str_replace('sdm_', '', $post_type);

            // $tax = 'product_category';
            $terms = wp_get_object_terms( get_the_ID(), $tax, array('fields' => 'ids') );
            if (!empty($terms)) {

                $qargs = array(
                        'post_type'         => $post_type,
                        'posts_per_page'    => -1,
                    );
                $qargs['tax_query'] = array(
                                            array(
                                                'taxonomy'      => $tax,
                                                'terms'         => $terms,
                                                ),
                        );

                $query = new WP_Query($qargs);
                if ($query->have_posts()) {
                    $r .= '<div class="wrapper related-content" id="'.$anchor.'">';
                        $post_type_object = get_post_type_object( $post_type );
                        $r .= '<h3 class="related-content-title">'. sprintf( __( 'Related %s', 'epicpower' ), $post_type_object->labels->name ) . '</h3>';

                        if ('sdm_downloads' == $post_type) {

                            $r .= do_shortcode( '[listado desplegado="true" tax_query_tax="'.$tax.'" tax_query_ids="'.implode(',', $terms).'"]' );

                            // $r .= '<ul class="listado">';

                            // while ($query->have_posts()) {
                            //     $query->the_post();
                            //     $r .= '<li><a href="'.get_the_permalink().'" target="_blank"><span class="fa fa-download"></span> '.get_the_title().'</a></li>';
                            // }

                            // $r .= '</ul>';

                            $r .= '<a class="link-plus mt-4" href="'.get_the_permalink( DOWNLOADS_ID ).'" target="_blank">'.__( 'Download center', 'epicpower' ).'</a>';

                        } else {

                            $r .= '<div class="row">';
                            // $r .= '<div class="card-deck">';
                                while ($query->have_posts()) { $query->the_post();
                                    $r .= '<div class="col-sm-6 col-md-4 col-lg-3 mb-4">';
                                        ob_start();

                                            get_template_part( 'loop-templates/content', 'product' );

                                        $r .= ob_get_clean();
                                    $r .= '</div>';
                                }
                            $r .= '</div>';
                        }
                    $r .= '</div>';
                }
                wp_reset_postdata();

            }
        }

        return $content . $r;
    }
    return $content;
}

add_filter( 'post_type_archive_link', 'sumun_sustituir_post_type_archive_por_pagina', 10, 2);
function sumun_sustituir_post_type_archive_por_pagina( $link, $post_type ) {
    $post_types = get_post_types( array(
        'public'        => true,
        '_builtin'      => false,
    ) );

    if('post' == get_post_type()) {
        $blog_page_id = get_option( 'page_for_posts' );
        $link = get_permalink( $blog_page_id );
    } else {
        $page_id = get_theme_mod( $post_type . '_archive_page_id' );
        if($page_id) {
            $link = get_the_permalink( $page_id );
        }
    }

    return $link;
}

add_filter( 'wpseo_breadcrumb_single_link_info', 'sumun_yoast_seo_breadcrumg_modificaciones', 10, 3 );
function sumun_yoast_seo_breadcrumg_modificaciones( $link_info, $index, $crumbs) {

    $archive_page_id = false;

    if( isset($link_info['ptarchive']) ) {
        $archive_page_id = get_theme_mod( $link_info['ptarchive'] . '_archive_page_id' );
        unset($link_info['ptarchive']);
    } elseif( isset($link_info['term_id']) ) {
        $archive_page_id = get_theme_mod( $link_info['term_id'] . '_term_page_id' );
        unset($link_info['term_id']);
    }

    if($archive_page_id) {
        $link_info['url'] = get_the_permalink( $archive_page_id );
        $link_info['text'] = get_the_title( $archive_page_id );
        $link_info['id'] = $archive_page_id;
    }

    return $link_info;
}

add_filter( 'wpseo_breadcrumb_links', 'eipcpower_quitar_categoria_de_miga_de_pan' );
function eipcpower_quitar_categoria_de_miga_de_pan( $crumbs ) {

    if ( is_singular( 'post' ) || is_category() ) {

        foreach( $crumbs as $i => $crumb ) {

            if( isset( $crumb['term_id'] ) ) {
                unset( $crumbs[$i] );
            }

        }

    }

    if ( is_post_type_archive( 'paper' ) || is_singular( 'paper' ) ) {
        $academy_id = defined( 'ACADEMY_ID' ) ? ACADEMY_ID : false;
        if ( $academy_id ) {
            $academy_link = array(
                'url'  => get_permalink( $academy_id ),
                'text' => get_the_title( $academy_id ),
                'id'   => $academy_id,
            );
            array_splice( $crumbs, 1, 0, array( $academy_link ) );
        }
    }

    return $crumbs;
}

add_filter( 'body_class', 'clases_body' );
function clases_body( $classes ) {
    if (!is_singular()) return $classes;
    $contenedor_estrecho = get_post_meta( get_the_ID(), 'contenedor_estrecho', true );
    $ocultar_contenido = get_post_meta( get_the_ID(), 'ocultar_contenido', true );
    if (1 == $contenedor_estrecho) {
        $classes[] = 'contenedor-estrecho';
    }
    if (1 == $ocultar_contenido) {
        $classes[] = 'ocultar-contenido';
    }
    return $classes;
}

add_action('current_screen', 'recuperar_custom_fields_nativos');
function recuperar_custom_fields_nativos() {
    add_filter('acf/settings/remove_wp_meta_box', '__return_false');
}

// previous y next posts con menu_order
function sumun_previous_post_where() {
    global $post, $wpdb;
    return $wpdb->prepare( "WHERE p.menu_order < %s AND p.post_type = %s AND p.post_status = 'publish'", $post->menu_order, $post->post_type);
}
add_filter( 'get_previous_post_where', 'sumun_previous_post_where' );

function sumun_next_post_where() {
    global $post, $wpdb;
    return $wpdb->prepare( "WHERE p.menu_order > %s AND p.post_type = %s AND p.post_status = 'publish'", $post->menu_order, $post->post_type);
}
add_filter( 'get_next_post_where', 'sumun_next_post_where' );

function sumun_previous_post_sort() {
    return "ORDER BY p.menu_order desc LIMIT 1";
}
add_filter( 'get_previous_post_sort', 'sumun_previous_post_sort' );

function sumun_next_post_sort() {
    return "ORDER BY p.menu_order asc LIMIT 1";
}
add_filter( 'get_next_post_sort', 'sumun_next_post_sort' );

function epicpower_menu_toggler() {
    /*
    $slots = 25;
    ?> 
    <a href="#" class="epicpower-menu-toggler izq">
        <?php for ($i=1; $i <= $slots; $i++) { 
            $delay = rand(0,700);
            echo '<span id="slot-'.$i.'" style="transition-delay:'.$delay.'ms;animation-delay:'.$delay.'ms;"></span>';
        } ?>
    </a>
    <?php
    */

    ?>

    <a href="#" class="epicpower-menu-toggler">
        <span class="slot slot-1"></span>
        <span class="slot slot-2"></span>
        <span class="slot slot-3"></span>
    </a>

    <?php

}

add_action( 'pre_get_posts', 'epicpower_pre_get_posts' );
function epicpower_pre_get_posts($query) {
    if (!$query->is_main_query() || is_admin() ) return;

    if (is_search()) {
        $query->set('posts_per_page', 30);
    }
    if (is_post_type_archive('case_study')) {
        $query->set('posts_per_page', -1);
    }

    if ($query->is_home() && !isset( $_GET['ptf'] ) ) {
        $query->set( 'post_type', array('post', 'case_study') );
    }

    if ( isset( $_GET['ptf'] ) ) {
        $query->set( 'post_type', $_GET['ptf'] );
    }

}

add_action('wp_footer', 'modal_quote_form');
function modal_quote_form() {
?>

<div id="quote-form" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-quote-form-label" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <!-- <h5 class="modal-title" id="modal-quote-form-label"></h5> -->
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <?php dynamic_sidebar( 'modal-quote-form' ); ?>
        </div>
    </div>
  </div>
</div>

<?php
}

add_action('wp_footer', 'modal_contact_form');
function modal_contact_form() { ?>

    <div id="contact-form" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-contact-form-label" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title" id="modal-quote-form-label"></h5> -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php dynamic_sidebar( 'modal-contact-form' ); ?>
            </div>
        </div>
    </div>
    </div>

<?php }


add_action( 'wp_footer', 'add_converters_sizes_modal_to_footer' );
function add_converters_sizes_modal_to_footer() {
    ?>
    <div id="modal-converters-sizes-guide" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-converters-sizes-guide-label" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-converters-sizes-guide-label"><?php _e('Size guide', 'epicpower'); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php dynamic_sidebar( 'converters-sizes-guide' ); ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}


// function get_datos_tecnicos_html( $text_field = false ) {

//     if (!$text_field) {
//         $text_field = get_post_meta( get_the_ID(), 'datos_tecnicos', true );
//     }
//     if($text_field) {

//         $exclude_info = array(
//             'V high side',
//             'V low side',
//             'Nominal current',
//             'Nominal power',
//         );
        
//         $datos_tecnicos = explode(PHP_EOL, $text_field);
//         $datos_tecnicos_html = '';
//         foreach ($datos_tecnicos as $row) {

//             $dato_array = explode(':', $row);

//             foreach ($exclude_info as $exclude) {
//                 if (stripos(trim($dato_array[0]), $exclude) !== false) {
//                     continue 2;
//                 }
//             }

//             $datos_tecnicos_html .= '<div class="row-wrapper '.ANIMATION_CLASS.'"><div class="row"><div class="col-6 data-label">'.$dato_array[0].'</div><div class="col-6 data-value">'.$dato_array[1].'</div></div></div>';
//         }

//         $tabla = '<div class="technical-table">' . $datos_tecnicos_html . '</div>';
    
//         return $tabla;

//     }

// }

function get_archive_filter( $taxonomy = 'industry', $post_type = 'case_study' ) {

    $r = '';

    if ( $taxonomy == 'blog' ) {

        $post_types = array(
            'post',
            'case_study',
        );

        $page_for_posts = get_option( 'page_for_posts' );

        $active_class = ( is_home() && !isset( $_GET['ptf'] ) ) ? 'active' : '';
        
        $r .= '<a href="'. get_permalink( $page_for_posts ).'" id="filter-item-all" class="filter-item '. $active_class .'" data-term="all">'.__( 'All', 'epicpower' ).'</a>';

        foreach ( $post_types as $post_type ) {
            $active_class = ( isset( $_GET['ptf'] ) && $_GET['ptf'] == $post_type ) ? 'active' : '';
            $post_type_label = get_post_type_object( $post_type )->labels->name;
            $r .= '<a href="'. get_post_type_archive_link( $post_type ) .'?ptf='. $post_type .'" class="filter-item '. $active_class .'" id="filter-item-'.$post_type.'" data-term="'.$post_type.'">'.$post_type_label.'</a>';
        }

    } else {

        $terms = get_terms( array(
                'taxonomy'      => $taxonomy,
                'hide_empty'    => true,
        ));


        if (!empty($terms)) {

            $r .= '<a href="#" id="filter-item-all" class="filter-item active" data-term="all">'.__( 'All', 'epicpower' ).'</a>';

            foreach ($terms as $term) {

                $posts = get_posts( array(
                    'post_type'         => $post_type,
                    'posts_per_page'    => 1,
                    'tax_query'         => array(
                                            array(
                                                'taxonomy'      => $taxonomy,
                                                'terms'         => $term->term_id,
                                            )
                    )
                ) );
                
                if($posts) {
                    $r .= '<a href="#" class="filter-item" id="filter-item-'.$term->slug.'" data-term="'.$term->slug.'">'.$term->name.'</a>';
                }

            }

            ob_start(); ?>

                <script type="text/javascript">
                    jQuery('.filter-item').click(function(e){
                        e.preventDefault();
                        jQuery('.filter-item').removeClass('active');
                        jQuery('.filtrable article').parent().removeClass('disabled');
                        jQuery(this).addClass('active');
                        var termSlug = jQuery(this).attr('data-term');
                        if (termSlug != 'all') {
                            jQuery('.filtrable article:not(.<?php echo $taxonomy; ?>-' + termSlug +')').parent().addClass('disabled');
                        }
                        var activeItems = jQuery('.filtrable article').parent().not('.disabled');
                        var inactiveItems = jQuery('.filtrable article').parent('.disabled');
                        jQuery('.filtrable > .row').append(activeItems).append(inactiveItems);
                    });
                </script>


            <?php $r .= ob_get_clean();

        }

    }

    if ( !$r ) return false;

    $output = '<div id="archive-filter" class="archive-filter">';
       
        $output .= $r;

    $output .= '</div>';

    return $output;
}

function understrap_post_nav() {
    return false;
}

function get_video_background( $url = false ) {

    if(wp_is_mobile()) return false;

    if(!$url) $url = get_post_meta( get_the_ID(), 'url_video_cabecera', true );
    if(!$url) return false;
    parse_str( parse_url( $url, PHP_URL_QUERY ), $vars );

    if( !isset($vars['v']) ) return false;
    $id = $vars['v'];

    // $url = 'https://youtu.be/djV11Xbc914';
    // $id = 'djV11Xbc914';

    // return '<div class="video-background">
    //             <div class="video-foreground">
    //               <a href="'.$url.'" class="lazy-youtube-embed">'.__( 'View media', 'epicpower' ).'</a>
    //             </div>
    //         </div>';  

    return '<div class="video-background">
                <div class="video-foreground">
                  <iframe src="https://www.youtube-nocookie.com/embed/'.$id.'/?controls=0&showinfo=0&rel=0&autoplay=1&mute=1&loop=1&disablekb=1&fs=0&modestbranding=1&iv_load_policy=3&playlist='.$id.'" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>';  
}
function video_background( $url = false ) {
    echo get_video_background( $url );
}

