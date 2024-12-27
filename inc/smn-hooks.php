<?php
/**
 * Custom hooks.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

add_filter( 'wpcf7_form_tag', 'smn_wpcf7_form_control_class', 10, 2 );
function smn_wpcf7_form_control_class( $scanned_tag, $replace ) {

   $excluded_types = array(
        'acceptance',
        'checkbox',
        'radio',
   );

   if ( in_array( $scanned_tag['type'], $excluded_types ) ) return $scanned_tag;

   switch ($scanned_tag['type']) {
    case 'submit':
        $scanned_tag['options'][] = 'class:btn';
        $scanned_tag['options'][] = 'class:btn-primary';
        break;
    
    default:
        $scanned_tag['options'][] = 'class:form-control';
        break;
   }
   
   return $scanned_tag;
}

function smn_cf7_get_referer_page( $form_tag ) {
    if (isset($_SERVER['HTTP_REFERER']) && $form_tag['name'] == 'referer-page' ) {
        $form_tag['values'][] = htmlspecialchars($_SERVER['HTTP_REFERER']);
    }
    return $form_tag;
}
if ( !is_admin() ) {
    add_filter( 'wpcf7_form_tag', 'smn_cf7_get_referer_page' );
}


add_action( 'loop_start', 'archive_loop_start', 10 );
function archive_loop_start( $query ) {

    if ( isset( $query->query['ignore_row'] ) && $query->query['ignore_row'] ) return false;
    
    if ( ( isset( $query->query['add_row'] ) && $query->query['add_row'] ) || ( is_archive() || is_home() || is_search() ) ) {
        echo '<div class="row">';
    }
}

add_action( 'loop_end', 'archive_loop_end', 10 );
function archive_loop_end( $query ) {

    if ( isset( $query->query['ignore_row'] ) && $query->query['ignore_row'] ) return false;

    if ( ( isset( $query->query['add_row'] ) && $query->query['add_row'] ) || ( is_archive() || is_home() || is_search() ) ) {
        echo '</div>';
    }
}

add_filter( 'body_class', 'smn_body_classes' );
function smn_body_classes( $classes ) {

    if ( is_page() ) {

        $navbar_bg = get_post_meta( get_the_ID(), 'navbar_bg', true );

        if ( 'transparent' == $navbar_bg ) {
            $classes[] = 'navbar-transparent';
        } elseif( smn_has_alignfull_first() ) {
            $classes[] = 'has-not-content-padding-top';
        }
        
    } else {

    }

    return $classes;
}


add_filter( 'post_class', 'bootstrap_post_class', 10, 3 );
function bootstrap_post_class( $classes, $class, $post_id ) {

    if ( is_archive() || is_home() || is_search() || in_array( 'hfeed-post', $class ) ) {
        $classes[] = COL_CLASSES; 
    }

    return $classes;
}

add_filter( 'understrap_site_info_content', 'site_info_do_shortcode' );
function site_info_do_shortcode( $site_info ) {
    return do_shortcode( $site_info );
}

add_action( 'wp_body_open', 'top_anchor');
function top_anchor() {
    echo '<div id="top"></div>';
}

// add_action( 'wp_footer', 'back_to_top' );
function back_to_top() {
    echo '<a href="#top" class="back-to-top"></a>';
}

function es_blog() {

    if( is_singular('post') || is_category() || is_tag() || ( is_home() && !is_front_page() ) ) {
        return true;
    }

    return false;
}

add_filter( 'theme_mod_understrap_sidebar_position', 'cargar_sidebar');
function cargar_sidebar( $valor ) {

    $valor = 'none';

    if ( es_blog() || is_singular( 'job_offer' ) ) {
        $valor = 'right';
    }

    return $valor;

}

add_filter( 'theme_mod_understrap_navbar_type', function( $value ) {
    return 'offcanvas';
});

function smn_nav_menu_submenu_css_class( $classes, $args, $depth ) {

    if ( !$args->walker && 'primary' === $args->theme_location ) {
        $classes[] = 'dropdown-menu';
        // $classes[] = 'collapse';
    }

    return $classes;

}
add_filter( 'nav_menu_submenu_css_class', 'smn_nav_menu_submenu_css_class', 10, 3 );

function smn_add_menu_item_classes( $classes, $item, $args ) {

    if ( !$args->walker && 'primary' === $args->theme_location ) {
        $classes[] = "nav-item";

        if( in_array( 'current-menu-item', $classes ) ) {
            $classes[] = "active";
        }

        if ( in_array( 'menu-item-has-children', $classes ) ) {
            $classes[] = 'dropdown';
        }

        if ( current_user_can( 'manage_options' ) ) :
            echo '<pre>';
                print_r ( $item );
            echo '</pre>';
        endif;
        
    }

    if ( 'primary' === $args->theme_location && $item->menu_item_parent == 0 ) {

        $megamenu = get_field( 'megamenu', $item->ID );
        if ( $megamenu ) {
            $classes[] = 'megamenu';
        }

    }
 
    return $classes;
}
add_filter( 'nav_menu_css_class' , 'smn_add_menu_item_classes' , 10, 4 );

function smn_add_menu_link_classes( $atts, $item, $args ) {

    if ( !$args->walker && 'primary' == $args->theme_location ) {

    if ( 0 == $item->menu_item_parent ) {
            $atts['class'] = 'nav-link';
        } else {
            $atts['class'] = 'dropdown-item';
        }
    }

    if ( in_array( 'menu-item-has-children', $item->classes ) ) {
        if ( isset( $atts['class'] ) ) $atts['class'] .= ' dropdown-toggle';
    }

    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'smn_add_menu_link_classes', 10, 3 );

add_filter('nav_menu_item_args', function ($args, $item, $depth) {

    if ( !$args->walker && 'primary' == $args->theme_location ) {
        
        $args->link_after  = '<span class="sub-menu-toggler"></span>';

    }
    return $args;
}, 10, 3);

add_filter( 'parse_tax_query', 'smn_do_not_include_children_in_product_cat_archive' );
function smn_do_not_include_children_in_product_cat_archive( $query ) {
    if ( 
        ! is_admin() 
        && $query->is_main_query()
        && $query->is_tax( 'product_cat' )
    ) {
        $query->tax_query->queries[0]['include_children'] = 0;
    }
}

function smn_set_current_menu_item( $item_output, $item, $depth, $args ) {
    global $current_menu_item;
    $current_menu_item = $item;
    return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'smn_set_current_menu_item', 10, 4);

add_filter( 'private_title_format', 'smn_private_title_format', 10, 2 );
function smn_private_title_format( $prepend, $post ) {
    return '%s <span class="post-visibility-status">::::: [' . __( 'Private' ) . ']</span>';
}

add_filter( 'protected_title_format', 'smn_protected_title_format', 10, 2 );
function smn_protected_title_format( $prepend, $post ) {
    return '%s <span class="post-visibility-status">::::: [' . __( 'Protected' ) . ']</span>';
}