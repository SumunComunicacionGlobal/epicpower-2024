<?php
// Create id attribute allowing for custom "anchor" value.
$id = 'products-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'products';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

$query_args = array(
	'post_type'			=> 'product',
	'posts_per_page'	=> -1,
);

// Load values and assign defaults.
$mostrar_productos = get_field('mostrar_productos') ?: 'seleccionar';
if ('seleccionar' == $mostrar_productos ) {
	$seleccionados = get_field('productos');

	$query_args['post_type'] = 'any';
	$query_args['post__in'] = $seleccionados;
	$query_args['orderby'] = 'post__in';
} elseif ('categoria' == $mostrar_productos) {
	$terms = get_field('categoria_de_productos');
	$tax_query = array();
	$tax_query[] = array(
		'taxonomy'		=> 'product_category',
		'terms'			=> $terms,
	);
	$query_args['tax_query'] = $tax_query;

}

$q = new WP_Query($query_args);

if ($q->have_posts()) {

	$layout = get_field( 'productos_layout' );

	if ( $layout == 'table' ) {

		$collapse_button_class = 'collapsed';
		$collapse_class = '';

		$field_keys = get_field( 'field_keys' );
		$detail_field_keys = get_field( 'detail_field_keys' );

		if ( $field_keys ) {

			$field_keys = explode( ',', $field_keys );

		} else {

			$field_keys = array(
				'isolated',
				'high_side_voltage',
				'low_side_voltage',
				'power_per_unit',
			);

		}

		while ( $q->have_posts() ) { 
			$q->the_post();

			$table_header = array(
				__( '', 'smn' ),
			);
	
			global $post;

			foreach ( $field_keys as $field_key ) {

				$field_code = get_post_meta( get_the_ID(), '_' . $field_key, true );
				$field_object = get_field_object( $field_code );
				$field_label = $field_object['label'];
				$table_header[] = $field_label;

			}

			// break;

		}

		// if ( 1 == get_current_user_id(  ) ) {
		// 	$collapse_button_class = '';
		// 	$collapse_class = 'show';
		// }

		echo '<div class="accordion accordion-flush" id="productsAccordion">';

		echo '<div class="accordion-button d-none d-md-block">';
			echo '<div class="button-cells small fw-bold">';
				foreach ($table_header as $header) {
					echo '<span>'.$header.'</span>';
				}
			echo '</div>';
		echo '</div>';


		while ($q->have_posts()) { 
			$q->the_post();
			global $post;
			$product_id = get_the_ID();
			$product_title = get_the_title();
			$product_content = get_the_content();
			$product_excerpt = smn_get_product_excerpt( $post, $detail_field_keys );

			$button_text_before = '<span class="small d-none d-md-inline-block text-primary-200">';
			$button_text_after = '</span>';

			$button_text = '<span class="fw-bold">' . $product_title . '</span>';

			foreach ( $field_keys as $key ) {
				$field_object = get_field_object( $key, $post );
				$value = get_field( $key, $post );

				if ( 'true_false' == $field_object['type'] ) {
					if ( $value ) {
						$value = __( 'Yes', 'epicpower' );
					} else {
						$value = __( 'No', 'epicpower' );
					}
				} elseif ( $field_object['append'] ) {
					$value .= '&nbsp;' . $field_object['append'];
				}
				$button_text .= $button_text_before . $value . $button_text_after;
			}

			$link = add_query_arg(
				'referer-product', 
				urlencode($product_title), 
				get_permalink(CONTACT_ID)
			);
			?>

			<div class="accordion-item">
				<h2 class="accordion-header" id="heading<?php echo $product_id; ?>">
					<button class="accordion-button <?php echo $collapse_button_class; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $product_id; ?>" aria-expanded="true" aria-controls="collapse<?php echo $product_id; ?>">
						<div class="button-cells"><?php echo $button_text; ?></div>
					</button>
				</h2>
				<div id="collapse<?php echo $product_id; ?>" class="accordion-collapse collapse <?php echo $collapse_class; ?>" aria-labelledby="heading<?php echo $product_id; ?>" data-bs-parent="#productsAccordion">
					<div class="accordion-body py-5">
						<div class="row">
							<div class="col-md-5 col-lg-6 mb-3">
								<?php echo $product_excerpt; ?>
								<?php edit_post_link(); ?>
							</div>
							<div class="col-md-7 col-lg-6 mb-3">
								
								<div class="row">
									<div class="col-md-6 mb-3">
										<?php echo smn_get_product_links(); ?>
									</div>
									<div class="col-md-6 mb-3 text-end">
										<a href="<?php echo $link; ?>" class="btn btn-outline-primary"><?php _e( 'Contact sales', 'epicpower' ); ?></a>
									</div>
								</div>

								<?php the_post_thumbnail(); ?>

							</div>
						</div>

						<?php if ( $product_content ) {
							echo '<hr class="mt-5">';
							echo $product_content; 
						} ?>

					</div>
				</div>
			</div>
		
		<?php }

		echo '</div>';

	} else {

		$enlace_a_descargas = get_field( 'enlace_a_descargas' );
		$args = array( 
			'enlace_a_descargas' => $enlace_a_descargas
		);

		echo '<div class="row related-content">';

			while ($q->have_posts()) { $q->the_post();

				echo '<div class="col-sm-6 animado">';
				
					get_template_part( 'loop-templates/content', 'product', $args );

				echo '</div>';
			}

		echo '</div>';

	}

}

wp_reset_postdata();
?>