<?php
/**
 * Hero setup
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$post_type = 'testimonio';

$args = array(
	'post_type'			=> $post_type,
	'posts_per_page'	=> 6,
	'orderby'			=> 'rand'
);

$q = new WP_Query($args);

if ( $q->have_posts() ) { ?>

	<div class="slick-slider-default slider-testimonios">

		<?php while ( $q->have_posts() ) { $q->the_post();

			get_template_part( 'loop-templates/content', $post_type );

		} ?>

	</div>

<?php }

wp_reset_postdata();
