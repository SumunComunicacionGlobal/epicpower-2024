<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( es_blog() ) {
	return false;
}

$args = array(
	'posts_per_page'	=> 6,
	'ignore_row'		=> true,
);

$q = new WP_Query($args);

if ( $q->have_posts() ) { ?>

	<div class="wrapper blog-block" id="wrapper-blog">

		<div class="slick-carousel">

			<?php while ( $q->have_posts() ) { $q->the_post();

				get_template_part( 'loop-templates/content', 'post' );

			} ?>

		</div>

	</div>

<?php }

wp_reset_postdata();
