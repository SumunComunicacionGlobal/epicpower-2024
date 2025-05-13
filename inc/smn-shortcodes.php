<?php 

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

function testimonios() {
	ob_start();
	get_template_part( 'global-templates/carousel-testimonios' );
	$r = ob_get_clean();

	return $r;
}
add_shortcode( 'testimonios', 'testimonios' );

function smn_get_reusable_block( $block_id = '' ) {
    if ( empty( $block_id ) || (int) $block_id !== $block_id ) {
        return;
    }
    $content = get_post_field( 'post_content', $block_id );
    return apply_filters( 'the_content', $content );
}

function smn_reusable_block( $block_id = '' ) {
    echo smn_get_reusable_block( $block_id );
}

function smn_reusable_block_shortcode( $atts ) {
    extract( shortcode_atts( array(
        'id' => '',
    ), $atts ) );
    if ( empty( $id ) || (int) $id !== $id ) {
        return;
    }
    $content = smn_get_reusable_block( $id );
    return $content;
}
add_shortcode( 'reusable', 'smn_reusable_block_shortcode' );

function sumun_shortcode_subcategorias() {
	ob_start();
	get_template_part( 'global-templates/subcategories' );
	$r = ob_get_clean();

	return $r;
}
add_shortcode( 'subcategorias', 'sumun_shortcode_subcategorias' );

function sumun_shortcode_blog() {
	ob_start();
	get_template_part( 'global-templates/blog' );
	$r = ob_get_clean();

	return $r;
}
add_shortcode( 'blog', 'sumun_shortcode_blog' );

function sumun_shortcode_casos_de_exito() {
	ob_start();
	get_template_part( 'global-templates/casos-de-exito' );
	$r = ob_get_clean();

	return $r;
}
add_shortcode( 'casos_de_exito', 'sumun_shortcode_casos_de_exito' );

add_shortcode( 'breadcrumb', 'smn_get_breadcrumb' );
add_shortcode( 'breadcrumbs', 'smn_get_breadcrumb' );

function listado_shortcode( $atts ) {
    $a = shortcode_atts( array(
        'icono' 		=> 'download',
        'categoria'  	=> 0,
        'post_type'		=> 'sdm_downloads',
        'taxonomy'		=> 'sdm_categories',
        'tax_query_tax'	=> false,
        'tax_query_ids'	=> false,
        'desplegado'	=> false,
    ), $atts );

    $qargs = array(
    		'post_type'			=> $a['post_type'],
    		'posts_per_page'	=> -1,
    		'tax_query'			=> array(),
    	);

    $secondary_tax_query = false;
    if ($a['tax_query_ids']) {
    	$secondary_tax_query = array(
    			'taxonomy'	=> $a['tax_query_tax'],
    			'terms'		=> explode(',', $a['tax_query_ids']),
    	);
    }

    // $show_class = ($a['desplegado']) ? 'show' : '';
    // $collapsed_class = ($a['desplegado']) ? '' : 'collapsed';
    $show_class = 'show';
    $collapsed_class = '';

	$r = '';
	$filtro_activo = '';

    $terms = get_terms( array( 'taxonomy' => $a['taxonomy'], 'parent' => $a['categoria'] ) );
    if ($terms) {

		if(isset($_GET['product_cat_filter'])) {

			$r .= '<style>';
				$r .= '.filtrable li { opacity: 0.2; }';
				$cats = explode(',', $_GET['product_cat_filter']);
				foreach ($cats as $slug ) {
					$prod_cat = get_term_by( 'slug', $slug, 'product_category' );
					$r .= '.filtrable li.product-cat-filter-item-' . $slug . ' { opacity: 1; }';
					$filtro_activo .= '<span class="badge bg-light text-dark rounded-pill mr-2 me-2">'.$prod_cat->name.'</span>';
				}
			$r .= '</style>';

			if ( isset($_GET['product_id']) ) {
				$product_id = $_GET['product_id'];
				$product_name = get_the_title( $product_id );
				$r .= '<p class="lead">' . sprintf( __( 'Showing downloads for %s', 'epicpower' ), '<span class="fw-bold">' . $product_name . '</span>' ) . '. '. __( 'Other downloads are shown in a lighter color', 'epicpower' ) .'</p>';
				$filtro_activo = '<span class="badge bg-light text-dark rounded-pill">'. sprintf( __( 'Related to %s', 'epicpower' ), $product_name ).'</span>' . $filtro_activo;
			}

			if($filtro_activo) $r .= '<p>' . $filtro_activo . '<a class="badge bg-primary text-white rounded-pill" href="'.get_the_permalink( DOWNLOADS_ID ).'">['.__('View all', 'epicpower').']</a></p>';
		}
	
    	$r .= '<div class="listado-shortcode row filtrable">';

		foreach ($terms as $term) {
    		$r .= '<div class="col-md-12 animado">';
    			$qargs['tax_query'] = array();
    			if($secondary_tax_query) $qargs['tax_query'][] = $secondary_tax_query;
		    	$qargs['tax_query'][] = array(
	    									'taxonomy'		=> $a['taxonomy'],
	    									'field'			=> 'slug',
	    									'terms'			=> $term->slug,
	    								);

			    $query = new WP_Query($qargs);
			    if ($query->have_posts()) {

					if (!$a['desplegado']) {
			    		$r .= '<h4 class="listado-term-title"><a class="link-collapse '.$collapsed_class.'" href="#listado-'.$term->term_id.'" data-bs-toggle="collapse" aria-expanded="false" aria-controls="listado-'.$term->term_id.'">'.$term->name.'</a></h4>';
			    	}
			    	$r .= '<ul id="listado-'.$term->term_id.'" class="collapse '.$show_class.' listado '.$a['post_type'];
			    	if ( 0 != $a['categoria'] ) $r .= ' ' . $a['categoria'];
			    	$r .= '">';

			    	while ($query->have_posts()) {
			    		$query->the_post();
						// $url = get_post_meta(get_the_ID(), 'sdm_upload', true);
						$url = get_the_permalink();
						$clases_descarga_product_cats = '';
						$descarga_product_cats = wp_get_post_terms( get_the_ID(), 'product_category', array(
							// 'fields'		=> 'slug',
						) );

						foreach ($descarga_product_cats as $product_cat ) {
							$clases_descarga_product_cats .= ' product-cat-filter-item-' . $product_cat->slug;
						}
			    		$r .= '<li class="'.$clases_descarga_product_cats.'">';
			    			// $r .= '<a href="'.$url.'" target="_blank" rel="noopener noreferrer" onClick="ga(\'send\', \'event\', { eventCategory: \'Descarga\', eventAction: \'click\', eventLabel: \'Area descargas\', eventValue: \''.get_the_title().'\'});"><span><i class="fa fa-'.$a['icono'].'"></i> '.get_the_title();
			    			// 	if($a['desplegado']) $r .= '<span class="download-category-label"> - '.$term->name.'</span>';
			    			// 	$r .= '</span>';
			    			// $r .= '<span>'.__( 'Download', 'epicpower' ).'</span></a>';
			    			$r .= '<a href="'.$url.'" target="_blank" rel="noopener noreferrer" onClick="ga(\'send\', \'event\', { eventCategory: \'Descarga\', eventAction: \'click\', eventLabel: \'Area descargas\', eventValue: \''.get_the_title().'\'});"><span><i class="fa fa-'.$a['icono'].'"></i> '.get_the_title();
			    				$r .= '</span>';
			    			$r .= '<span class="download-category-label">'.$term->name.'</span></a>';
			    		$r .= '</li>';
			    	}

			     	$r .= '</ul>';
			    }
			    wp_reset_postdata();

			$r .= '</div>';
		}
		$r .= '</div>';
	}
    return $r;
}
add_shortcode( 'listado', 'listado_shortcode' );

function contenido_pagina($atts) {

	$content = '';

	// remove_filter('the_content', 'mostrar_sidebar_producto', 70, 1);
	remove_filter('the_content', 'mostrar_paginas_hijas', 1000, 1 );

	extract( shortcode_atts(
		array(
				'id' 	=> 0,
				'imagen'	=> 'no',
				'dominio'	=> false,

		), $atts)	
	);
	if ($dominio) {
		$api_url = $dominio . '/wp-json/wp/v2/pages/' . $id;
		$data = wp_remote_get( $api_url );
		$data_decode = json_decode( $data['body'] );

		$content .= $data_decode->content->rendered;

	} else {
		if ( 0 != $id) {
			$content_post = get_post($id);
			// $content .= $content_post->post_content;
			$content .= '<div class="post-content-container">'.apply_filters('the_content', $content_post->post_content) .'</div>';
			if ('si' == $imagen) {
				$content .= '<div class="entry-thumbnail">'.get_the_post_thumbnail($id, 'full') . '</div>' . $content;
			}

		}
	}

	// add_filter('the_content', 'mostrar_sidebar_producto', 70, 1);
	add_filter('the_content', 'mostrar_paginas_hijas', 1000, 1 );

	return $content;

}
add_shortcode('contenido_pagina','contenido_pagina');

function home_url_shortcode() {
	return get_home_url();
}
add_shortcode('home_url','home_url_shortcode');

function theme_url_shortcode() {
	return get_stylesheet_directory_uri();
}
add_shortcode('theme_url','theme_url_shortcode');

function uploads_url_shortcode() {
	$upload_dir = wp_upload_dir();
	$uploads_url = $upload_dir['baseurl'];
	return $uploads_url;
}
add_shortcode('uploads_url','uploads_url_shortcode');

function year_shortcode() {
  $year = date('Y');
  return $year;
}
add_shortcode('year', 'year_shortcode');

function term_link_sh( $atts ) {
	extract( shortcode_atts(
		array(
				'id' 	=> 0,
		), $atts)	
	);
	$id = intval($id);
	return get_term_link( $id );
}
add_shortcode('cat_link', 'term_link_sh');

function post_link_sh( $atts ) {
	extract( shortcode_atts(
		array(
				'id' 	=> 0,
		), $atts)	
	);
	$id = intval($id);
	return get_the_permalink( $id );
}
add_shortcode('post_link', 'post_link_sh');

// Link Sumun
function link_sumun( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'texto' => 'Diseño web: Sumun.net',
			'url'	=> 'https://sumun.net',
		), $atts )
	);

    $link = '<a href="'.$url.'" target="_blank" rel="noopener noreferrer">'.$texto.'</a>';
    if (is_front_page()) {
        return $link;
    }
    return $texto;
}
add_shortcode( 'link_sumun', 'link_sumun' );

function paginas_hijas( $atts ) {

	global $post;
	if ( !is_post_type_hierarchical( $post->post_type ) /*|| '' != $post->post_content */) return;

	$atts = shortcode_atts(
		array(
			'post_type'			=> array($post->post_type),
			'posts_per_page'	=> -1,
			'post_status'		=> 'publish',
			'orderby'			=> 'menu_order',
			'order'				=> 'ASC',
			'post_parent'		=> $post->ID,
			'imagenes'			=> true,
			'ids'				=> false,
			'columnas'			=> false,
			'mostrar_case_study' => false,
		),
		$atts
	);

	$post_type = $atts['post_type'];

	$args = array(
		'post_type'			=> $atts['post_type'],
		'posts_per_page'	=> $atts['posts_per_page'],
		'post_status'		=> $atts['post_status'],
		'orderby'			=> $atts['orderby'],
		'order'				=> $atts['order'],
	);

	if ($atts['ids']) {
		$args['post__in'] = explode(',', $atts['ids']);
		$args['orderby'] = 'post__in';
	} else {
		$args['post_parent'] = $atts['post_parent'];
	}

	$columnas = $atts['columnas'];
	
	$r = '';

	$imagenes = ($atts['imagenes'] === 'no') ? false : true;

	$query = new WP_Query($args);
	if ($query->have_posts() ) {
		$r .= '<div class="contenido-adicional">';
		// if ($imagenes) $r .= '<div class="row">';
		$r .= '<div class="row">';
		// $r .= '<h3>'.__( 'Contenido en', 'epicpower' ).' "'.$post->post_title.'"</h3>';
			// $r .= '<ul>';

				$col_class = 'col-md-6 col-lg-4';
				// if ($columnas) {

				// 	switch ($columnas) {
				// 		case 4:
				// 			$col_class = 'col-6 col-md-4 col-lg-3';
				// 			break;
						
				// 		case 3:
				// 			$col_class = 'col-6 col-md-4';
				// 			break;
						
				// 		case 2:
				// 			$col_class = 'col-6';
				// 			break;
						
				// 		case 1:
				// 			$col_class = 'col-12';
				// 			break;
						
				// 		default:
				// 			$col_class = 'col-6 col-md-4';
				// 			break;
				// 	}

				// } elseif ($query->found_posts >= 4) {
				// 	$col_class = 'col-sm-6 col-md-4 col-lg-3';
				// }

				$col_class .= ' ' . ANIMATION_CLASS;

				while($query->have_posts() ) {
					$query->the_post();
					global $post;
					// $r .= '<a class="link-plus pagina-hija" href="'.get_permalink( get_the_ID() ).'" title="'.get_the_title().'">'.get_the_title().'</a>';

					// if ($imagenes) {
						$r .= '<div class="'.$col_class.' mb-4 animado">';

							$link = get_permalink( get_the_ID() );

							if ( $imagenes ) {
								// $r .= get_the_post_thumbnail( null, 'medium', array('class' => 'imagen-pagina-hija') );
								$r .= '<div class="wp-block-cover wp-block-cover-pagina-hija align-items-end stretch-linked-block">';
									$r .= '<span aria-hidden="true" class="wp-block-cover__background has-dark-background-color has-background-dim-80 has-background-dim"></span>';
									$r .= get_the_post_thumbnail( get_the_ID(), 'medium_large', [ 'class' => 'wp-block-cover__image-background' ] );
									$r .= '<div class="wp-block-cover__inner-container">';
										$r .= '<p class="wp-block-cover__title h4 text-white mb-1"><a class="stretched-link" href="'. $link .'" title="'.get_the_title().'">'.get_the_title().'</a></p>';
										if ( $post->post_excerpt ) {
											$r .= '<div class="small">' . wpautop($post->post_excerpt) . '</div>';
										}
										$r .= '</div>';
								$r .= '</div>';

							} else {
								$r .= '<p class="h4"><a class="read-more fw-bold pagina-hija" href="'. $link .'" title="'.get_the_title().'">'.get_the_title().'</a></p>';
							}

							remove_filter( 'the_content', 'mostrar_paginas_hijas', 100 );
							// $excerpt = wpautop( $post->post_excerpt );
							// $excerpt = str_replace('"'.get_permalink($atts['post_parent'].'"'), '"'.$link.'"', $excerpt);

							// $r .= '<div class="small text-muted">' . $excerpt . '</div>';


							if ($atts['mostrar_case_study'] ) {

								$terms = wp_get_post_terms(get_the_ID(), 'industry');

								if (!empty($terms) && !is_wp_error($terms)) {
									$term_ids = wp_list_pluck($terms, 'term_id');
									$case_study_args = array(
										'post_type' => 'case_study',
										'posts_per_page' => 1,
										'orderby' => 'rand',
										'tax_query' => array(
											array(
												'taxonomy' => 'industry',
												'field' => 'term_id',
												'terms' => $term_ids,
											),
										),
									);
									$case_study_query = new WP_Query($case_study_args);
									if ($case_study_query->have_posts()) {
										while ($case_study_query->have_posts()) {
											$case_study_query->the_post();
											$r .= '<div class="case-study">';
												// $r .= get_the_post_thumbnail(get_the_ID(), 'medium', array('class' => 'case-study-thumbnail'));
												$r .= '<p class="fw-bold small mt-4 mb-1">'. __( 'Related Case Study', 'epicpower' ) .'</p>';
												$r .= '<p class="case-study-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></p>';
											$r .= '</div>';
										}
										wp_reset_postdata();
									}
								}

							}

							// $r .= get_permalink($atts['post_parent']) . '<br>';
							// $r .= str_replace('"'.get_permalink($atts['post_parent'].'"'), '"'.$link.'"', $r);


						$r .= '</div>';
					// } else {
					// 	$r .= '<a class="link-plus pagina-hija" href="'.get_permalink( get_the_ID() ).'" title="'.get_the_title().'">'.get_the_title().'</a>';
					// }
				}
				// $r .= '</ul>';
			// if ($imagenes) {
				$r .= '</div>';

			// 	// $r .= '<p class="mt-5 text-right"><a class="btn btn-outline-primary btn-lg" href="'.get_the_permalink( CONTACT_ID ).'" title="'.get_the_title( CONTACT_ID ).'">'.get_the_title( CONTACT_ID ).'</a></p>';
			// }
			
		$r .= '</div>';
	} else {
		if($post->post_parent != 0) {
			wp_reset_postdata();
			$current_post_id = get_the_ID();
			$args['post_parent'] = $post->post_parent;
			$query = new WP_Query($args);
			if ($query->have_posts() ) {
				$r .= '<div class="paginas-hermanas wrapper">';
				$r .= '<p><a class="link-plus" data-bs-toggle="collapse" href="#contenido-adicional-relacionado" role="button" aria-expanded="true" aria-controls="contenido-adicional-relacionado">'.__('Related content', 'epicpower').'</a></p>';
				$r .= '<div class="collapse show" id="contenido-adicional-relacionado">';
				while($query->have_posts() ) {
					$query->the_post();
					if ($current_post_id == get_the_ID()) {
						$r .= '<span class="btn btn-outline-light btn-sm mr-2 me-2 mb-2">'.get_the_title().'</span>';
					} else {
						$r .= '<a class="btn btn-outline-primary btn-sm mr-2 me-2 mb-2" href="'.get_permalink( get_the_ID() ).'" title="'.get_the_title().'">'.get_the_title().'</a>';
					}
				}
				$r .= '</div>';
				$r .= '</div>';
			}
		}
	}
	wp_reset_postdata();



	return $r;
}
add_shortcode( 'paginas_hijas', 'paginas_hijas' );

function paginas_hijas_cabecera() {

	global $post;
	if ( !is_post_type_hierarchical( $post->post_type ) /*|| '' != $post->post_content */) return;

	$atts = array(
			'post_type'			=> array($post->post_type),
			'posts_per_page'	=> -1,
			'post_status'		=> 'publish',
			'orderby'			=> 'menu_order',
			'order'				=> 'ASC',
			'post_parent'		=> $post->ID,
		);

	$args = array(
		'post_type'			=> $atts['post_type'],
		'posts_per_page'	=> $atts['posts_per_page'],
		'post_status'		=> $atts['post_status'],
		'orderby'			=> $atts['orderby'],
		'order'				=> $atts['order'],
		'post_parent'		=> $atts['post_parent'],
	);

	$r = '';

	$query = new WP_Query($args);
	if ($query->have_posts() ) {
		$class = '';
		$columnado = ($query->found_posts > 4) ? true : false;
		// $class = ($query->found_posts > 4) ? 'columnado' : '';
		$class = ($columnado) ? 'row' : '';
		$r .= '<div class="contenido-adicional ' .$class. '">';
		while($query->have_posts() ) {
			$query->the_post();

			$r .= '<div class="col-md-6">';
				$r .= '<a class="link-plus pagina-hija" href="'.get_permalink( get_the_ID() ).'" title="'.get_the_title().'">'.get_the_title().'</a>';
			$r .= '</div>';
		}
		$r .= '</div>';
	}
	wp_reset_postdata();



	return $r;
}

add_filter('the_content', 'mostrar_paginas_hijas', 1000);
function mostrar_paginas_hijas($content) {
	global $post;

	if(has_shortcode( $content, 'contenido_pagina' )) return $content;

	if (is_admin() || !is_singular() || !in_the_loop() || is_front_page() ) return $content;
	global $post;
	if (has_shortcode( $post->post_content, 'paginas_hijas' )) return $content;

	remove_filter('the_content', 'mostrar_paginas_hijas', 1000);
	return $content . do_shortcode( '[paginas_hijas]' );
	// return do_shortcode( '[paginas_hijas]' ) . $content;

}

function get_redes_sociales() {

	$r = '';
	
    $redes_sociales = array(
        'email' => 'envelope',
        'whatsapp' => 'whatsapp',
        'linkedin' => 'linkedin',
        'twitter' => 'twitter',
        'facebook' => 'facebook',
        'instagram' => 'instagram',
        'youtube' => 'youtube',
        'skype' => 'skype',
        'pinterest' => 'pinterest',
    );
    $r .= '<div class="redes-sociales">';

    foreach ($redes_sociales as $red => $fa_class) {
    	$url = get_theme_mod( $red, '' );
    	if( '' != $url) {
	    	$r .= '<a href="'.$url.'" target="_blank" rel="nofollow noopener noreferrer" title="'.sprintf( __( 'Abrir %s en otra pestaña', 'epicpower' ), $red ).'"><span class="red-social '.$red.' fa fa-'.$fa_class.'"></span></a>';
    	}
    }

    // $r .= '<span class="follow-us">' . __( 'Follow us', 'epicpower' ) . '</span>';

    $r .= '</div>';

    return $r;

}
add_shortcode( 'redes_sociales', 'get_redes_sociales' );

function get_info_basica_privacidad() {

	$r = '';
	
	$text = get_theme_mod( 'info_privacidad_formularios', '' );
	if( '' != $text) {
		$r .= '<div class="info-basica-privacidad">';
	    	$r .= wpautop( $text );
		$r .= '</div>';
	}

    return $r;

}
add_shortcode( 'info_basica_privacidad', 'get_info_basica_privacidad' );

function sitemap() {
	$pt_args = array(
		'has_archive'		=> true,
	);
	$pts = get_post_types( $pt_args );
	// if (isset($pts['rl_gallery'])) unset $pts['rl_gallery'];
	$pts = array_merge( array('page'), $pts, array('post') );
	$r = '';

	foreach ($pts as $pt) {
		$pto = get_post_type_object( $pt );
		$taxonomies = get_object_taxonomies( $pt );

		$posts_args = array(
				'post_type'			=> $pt,
				'posts_per_page'	=> -1,
				'orderby'			=> 'menu_order',
				'order'				=> 'asc',
		);

		$posts_q = new WP_Query($posts_args);
		if ($posts_q->have_posts()) {

			$r .= '<h3 class="mt-3">'.$pto->labels->name.'</h3>';
			if ($taxonomies) {
				foreach ($taxonomies as $tax) {
					$terms = get_terms( array('taxonomy' => $tax) );
					foreach ($terms as $term) {
						$r .= '<a href="'.get_term_link( $term ).'" class="btn btn-dark btn-sm mr-1 me-1 mb-1">'.$term->name.'</a>';
					}
				}
			}

			while ($posts_q->have_posts()) { $posts_q->the_post();
				$r .= '<a href="'.get_the_permalink().'" class="btn btn-outline-primary btn-sm mr-1 me-1 mb-1">'.get_the_title().'</a>';
			}
		}

		wp_reset_postdata();
	}

	return $r;
}
add_shortcode( 'sitemap', 'sitemap' );


function infografia_home( $atts ) {
	extract( shortcode_atts(
		array(
				'parent_page' 	=> 2346,
		), $atts)	
	);

    $post_type = get_post_type( $parent_page );
    $args = array(
        'post_type'         => $post_type,
        'post_parent'       => $parent_page,
        'posts_per_page'    => -1,
    );

    $q = new WP_Query($args);
    $r = '';

    if ($q->have_posts()) {

        $r .= '<div class="infografia-home">';

        while ($q->have_posts()) { $q->the_post();

        	$bg_url = get_the_post_thumbnail_url( null, 'medium_large' );
        	$style_css = ($bg_url) ? 'style="background-image:url('.$bg_url.')"' : '';
        	$icono = get_post_meta( get_the_ID(), 'icono', true );
        	$icono = ($icono) ? '<div class="infografia-home-icono">'.wp_get_attachment_image( $icono, 'medium' ).'</div>' : '';

            $r .= '<a href="'.get_the_permalink().'" class="infografia-home-item animado '.ANIMATION_CLASS.'" '.$style_css.'>';

                $r .= '<div class="infografia-home-overlay">'.$icono.'</div>';
                $r .= '<span class="infografia-home-label">'.get_the_title().'</span>';

            $r .= '</a>';

        }

        $r .= '</div>';
    }
    wp_reset_postdata();

    return $r;
}
add_shortcode( 'infografia_home', 'infografia_home' );


function epic_codigo_ticket() {
	return '#' . rand ( 1000000000 , 9999999999 ) . ': ';
}

function codigo_ticket_mail_tag( $output, $name, $html ) {
	if ( 'codigo_ticket' == $name )
		$output = epic_codigo_ticket();
 
	return $output;
}
add_filter( 'wpcf7_special_mail_tags', 'codigo_ticket_mail_tag', 10, 3 );

add_filter( 'wpcf7_posted_data', 'action_wpcf7_posted_data', 10, 1 );
function action_wpcf7_posted_data( $array ) { 
    $value = $array['your-subject'];
    $array['your-subject'] = epic_codigo_ticket() . $value;

    return $array;
}; 

function video_tutorials_shortcode() {
	ob_start();
	get_template_part('global-templates/video-tutorials');
	$r = ob_get_clean();

	return $r;
}
add_shortcode('video_tutorials', 'video_tutorials_shortcode');

function application_notes_shortcode() {
	ob_start();
	get_template_part('global-templates/application-notes');
	$r = ob_get_clean();

	return $r;
}
add_shortcode('application_notes', 'application_notes_shortcode');

function papers_shortcode() {
	ob_start();
	get_template_part('global-templates/papers');
	$r = ob_get_clean();

	return $r;
}
add_shortcode('papers', 'papers_shortcode');

function application_notes_filter_shortcode() {
	ob_start();
	get_template_part('global-templates/application-notes-filter');
	$r = ob_get_clean();

	return $r;
}
add_shortcode('application_notes_filter', 'application_notes_filter_shortcode');

function slider_shortcode() {
	ob_start();
	get_template_part('global-templates/hero');
	$r = ob_get_clean();

	return $r;
}
add_shortcode('slider', 'slider_shortcode');