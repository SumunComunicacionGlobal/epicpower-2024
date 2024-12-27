<?php
/**
 * Hero setup
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$post_type = 'slide';

$args = array(
	'post_type'			=> $post_type,
	'posts_per_page'	=> -1,
	'orderby'			=> 'menu_order',
	'order'				=> 'ASC',
);

$q = new WP_Query($args);

if ( $q->have_posts() ) { ?>

	<div class="slick-slider-default">

		<?php while ( $q->have_posts() ) { $q->the_post();

			get_template_part( 'loop-templates/content-slide', 'no-background' );

		} ?>

	</div>

<?php }

wp_reset_postdata();
