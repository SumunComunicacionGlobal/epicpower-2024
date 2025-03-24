<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function understrap_posted_on() {

    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
    }
    $time_string = sprintf( $time_string,
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() )
    );
    echo $time_string; // WPCS: XSS OK.
}




/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function understrap_entry_footer() {
    // Hide category and tag text for pages.
    if ( 'post' === get_post_type() ) {
        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category_list( esc_html__( ', ', 'understrap' ) );
        if ( $categories_list && understrap_categorized_blog() ) {
            /* translators: %s: Categories of current post */
            printf( '<span class="cat-links">' . esc_html__( '%s', 'understrap' ) . '</span>', $categories_list ); // WPCS: XSS OK.
        }
        /* translators: used between list items, there is a space after the comma */
        if (is_singular( 'post' ) || is_singular( 'portfolio_page' )) {
            $tags_list = get_the_tag_list( '', esc_html__( ' ', 'understrap' ) );
            if ( $tags_list ) {
                /* translators: %s: Tags of current post */
                printf( '<span class="tags-links text-primary">' . esc_html__( 'Tagged %s', 'understrap' ) . '</span>', $tags_list ); // WPCS: XSS OK.
            }
        }
    }

    edit_post_link(
        sprintf(
            /* translators: %s: Name of current post */
            esc_html__( 'Edit %s', 'understrap' ),
            the_title( '<span class="screen-reader-text">"', '"</span>', false )
        ),
        '<span class="edit-link">',
        '</span>'
    );
}


function smn_get_breadcrumb() {

	if ( is_front_page() ) return false;

	ob_start();

	if(function_exists('bcn_display')) {
		echo '<div class="breadcrumb" typeof="BreadcrumbList" vocab="https://schema.org/">';
			echo '<div class="breadcrumb-inner">';
				bcn_display();
			echo '</div>';
		echo '</div>';
	} elseif ( function_exists( 'rank_math_the_breadcrumbs') ) {
		echo '<div class="breadcrumb">';
			echo '<div class="breadcrumb-inner">';
				rank_math_the_breadcrumbs(); 
			echo '</div>';
		echo '</div>';
	} elseif ( function_exists('yoast_breadcrumb') ) {
		yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumb"><div class="breadcrumb-inner">','</div></div>' );
	}

	$r = ob_get_clean();

	if ( $r ) {
		return '<div class="breadcrumb-wrapper py-1">' . $r . '</div>';
	}

}

function smn_breadcrumb() {
	
	$r = smn_get_breadcrumb();

	if ( $r ) {
		echo '<div class="container-fluid">';
			echo $r;
		echo '</div>';
	}

}

function smn_get_navbar_class() {

	if ( NEW_HEADER ) {

		$navbar_class = get_post_meta( get_the_ID(), 'navbar_bg', true );

		if ( $navbar_class === 'transparent' ) {
			$navbar_class = 'navbar-dark';
		} else {
			$navbar_class = 'bg-white navbar-light';
		}

	} else {

		$navbar_class = 'bg-primary-400 navbar-dark';

		if ( is_page() ) {

			$navbar_bg = get_post_meta( get_the_ID(), 'navbar_bg', true );

			switch ($navbar_bg) {
				case 'navbar-light':
					$navbar_class = 'bg-white navbar-light';
					break;

				case 'navbar-dark':
					$navbar_class = 'bg-dark navbar-dark';
					break;

				// case 'transparent':
				// 	$navbar_class = 'bg-transparent navbar-dark';
				// 	break;
				
				default:
					$navbar_class = 'bg-dark navbar-dark';

				break;
			}

		} elseif ( is_singular( 'case_study' ) ) {
			$navbar_class = 'bg-primary-400 navbar-dark';
		}

	}

	return $navbar_class;

}

function smn_has_alignfull_first() {

	if ( !is_page() ) return false;

	$blocks = parse_blocks( get_the_content() );

	if ( isset( $blocks[0] ) && isset( $blocks[0]['attrs']['align'] ) && 'full' === $blocks[0]['attrs']['align'] ) {
		return true;
	}

	if ( isset( $blocks[0] ) && 
		(
			'core/cover' === $blocks[0]['blockName'] ||
			'nk/awb' === $blocks[0]['blockName']
		)
	) {
		return true;
	}

	return false;

}

function smn_get_product_excerpt( $product = null, $detail_field_keys = false ) {

	if ( !$product ) {
		global $post;
		$product = $post;
	}

	$subtitulo = get_field('subtitulo', $product);
	// $datos_tecnicos = get_field('datos_tecnicos', $product);
	// $datos_tecnicos_html = get_datos_tecnicos_html( $datos_tecnicos );

	$r = '';

	if ($subtitulo) $r .= '<p class="entry-subtitle fw-bold">'.$subtitulo.'</p>';
	if ($product->post_excerpt) $r .= '<div class="small mb-3">' . wpautop( $post->post_excerpt ) . '</div>';
	// if ($datos_tecnicos) $r .= '<div class="mb-3">' . $datos_tecnicos_html . '</div>';

	$fields = acf_get_fields(DATOS_TECNICOS_ID);

	if ( $detail_field_keys ) {
		$detail_field_keys = explode(',', $detail_field_keys);
		$fields = acf_get_fields(DATOS_TECNICOS_ID);
		$fields = array_filter( $fields, function($field) use ($detail_field_keys) {
			return in_array( $field['name'], $detail_field_keys );
		});
	}

	if ($fields) {
		$t = '';

		foreach ($fields as $field) {
			$field_value = get_field($field['name'], $product->ID);
			
			if ($field['type'] === 'true_false') {
				$field_value = $field_value ? __('Yes', 'epicpower') : __('No', 'epicpower');
			}

			if ($field_value) {
				$label = $field['label'];
				$append = isset($field['append']) ? $field['append'] : '';
				if ( $append ) $field_value = $field_value . '&nbsp;' . $append;

				if ( 'size' == $field['name'] && strpos($field_value, 'mm') === false ) {
					$superindex = '&nbsp;<sup class="help-superindex">?</sup>';
					$field_value = '<a href="#modal-converters-sizes-guide" data-bs-toggle="modal">'. $field_value . $superindex .'</a>';
				}

				$t .= '<div class="d-flex py-2 border-bottom flex-column flex-sm-row justify-content-between"><span class="me-2">' . esc_html($label) . ':</span> <span class="text-lg-end">' . $field_value . '</span></div>';
			}
		}

		if ( $t ) {
			$r .= '<div class="datos-tecnicos mb-3 small">' . $t . '</div>'; 
		}
	}

	return $r;

}

function smn_get_product_links( $product = null ) {

	if ( !$product ) {
		global $post;
		$product = $post;
	}

	$r = '';

	$datasheet_downloads = get_field('datasheet_downloads', $product );

	if ($datasheet_downloads) {
		$r .= wpautop( '<a href="'.get_the_permalink( $datasheet_downloads[0] ).'" title="'.__( 'Download datasheet', 'epicpower' ).'" target="_blank" rel="noopener noreferrer"><i class="fa fa-download"></i> '.__( 'Datasheet', 'epicpower' ).'</a>' );
	}

	$link = add_query_arg( array(
		'product_cat_filter'		=> implode(',', wp_get_post_terms( get_the_ID(), 'product_category', array( 'fields' => 'slugs') )),
		'product_id'					=> get_the_ID(),
	), get_the_permalink( DOWNLOADS_ID ) );

	$r .= wpautop( '<a href="'. $link .'" title="'. __( 'Related downloads', 'epicpower' ) .'" target="_blank" rel="noopener noreferrer"><i class="fa fa-download"></i> '. __( 'Related downloads', 'epicpower' ) . '</a>' );


	return $r;
}

function get_application_notes_product_categories($taxonomy, $postType) {
    // Get all terms that have posts
    $terms = get_terms($taxonomy, [
		'parent'	=> 0,
        'hide_empty' => true,
    ]);

    // Remove terms that don't have any posts in the current post type
    $terms = array_filter($terms, function ($term) use ($postType, $taxonomy) {
		$posts = get_posts([
			// 'fields' => 'ids',
			'numberposts' => 1,
			'post_type' => $postType,
			'tax_query' => [
			'relation' => 'AND',
			[
				'taxonomy' => $taxonomy,
				'terms' => $term,
			],
			[
				'taxonomy' => 'sdm_categories',
				'terms' => APPLICATION_NOTES_TERM_ID,
			],
			],
		]);

		return (count($posts) > 0);
    });

    // Return whatever we have left
    return $terms;
}