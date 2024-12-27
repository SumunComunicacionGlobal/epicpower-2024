<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( !is_tax() && !is_category() && !is_tag() ) return;
$current_term = get_queried_object();

$terms = get_terms( array( 
	'taxonomy' 		=> $current_term->taxonomy, 
	'parent' 		=> $current_term->term_id, 
	'hide_empty' 	=> true,
) );

if ( $terms ) { ?>

	<div class="slick-carousel">

		<?php foreach ( $terms as $key => $term ) { ?>

			<?php $img_id = get_term_meta( $term->term_id, 'thumbnail_id', true ); ?>

			<div class="card subcategory">

				<?php if ( $img_id ) echo wp_get_attachment_image( $img_id, 'medium', false, array( 'class' => 'card-img-top' ) ); ?>

				<div class="card-body">

					<p class="h5 card-title"><?php echo $term->name; ?></p>

				</div>

				<div class="wp-block-buttons d-flex justify-content-end">
					<div class="wp-block-button is-style-arrow-link">
						<a class="wp-block-button__link" href="<?php echo get_term_link( $term ); ?>" title="<?php echo $term->name; ?>"><?php echo __( 'Ver más', 'smn' ); ?></a>
					</div>
				</div>

			</div>

		<?php } ?>

	</div>

<?php } ?>