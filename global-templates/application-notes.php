<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
$post_type = 'sdm_downloads';
$term_id = APPLICATION_NOTES_TERM_ID;

$args = array(
	'post_type'			=> $post_type,
	'posts_per_page'	=> 6,
	'ignore_row'		=> true,
	'facetwp'			=> true,
);

if ( $term_id ) {

	$args['tax_query'] = array(
		array(
			'taxonomy'	=> 'sdm_categories',
			'field'		=> 'term_id',
			'terms'		=> $term_id,
		),
	);

}

$q = new WP_Query($args);

if ( $q->have_posts() ) { ?>

	<div class="wrapper application-notes" id="wrapper-application-notes">

		<div class="row">

			<?php while ( $q->have_posts() ) { $q->the_post();

				echo '<div class="col-md-6 col-lg-4 mb-4">';

					get_template_part( 'loop-templates/content', 'background' );

				echo '</div>';

			} ?>

		</div>

	</div>

<?php }

wp_reset_postdata();

echo do_shortcode( '[facetwp facet="pagination"]' );
