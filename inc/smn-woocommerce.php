<?php 

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Homogeneiza el breakpoint de WC con el de WP
add_filter( 'woocommerce_style_smallscreen_breakpoint', function() {
    return '782px'; 
});
 
// replace woocommerce breadcrumbs with smn_breadcrumb
function woocommerce_breadcrumb() {
    smn_breadcrumb();
}

// remove loop product category count mark
add_filter( 'woocommerce_subcategory_count_html', '__return_null' );

add_filter( 'woocommerce_product_review_comment_form_args', 'smn_review_form_args' );
function smn_review_form_args( $args ) {

    foreach( $args['fields'] as $key => $field_html ) {
        $args['fields'][$key] = str_replace( 
            array(
                '<input ', 
                '<textarea ',
            ),
            array(
                '<input class="form-control" ', 
                '<textarea class="form-control" ', 
            ),
        $field_html );
    }

    return $args;
}

// remove the subcategories from the product loop
remove_filter( 'woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories' );

// add subcategories before the product loop (yet after catalog_ordering and result_count -> see priority 40)
add_action( 'woocommerce_before_shop_loop', 'smn_show_product_subcategories', 40 );

function smn_show_product_subcategories() {
    $subcategories = woocommerce_maybe_show_product_subcategories();
        if ($subcategories) {
          echo '<div class="row subcategories">',$subcategories,'</div>';
    }
}