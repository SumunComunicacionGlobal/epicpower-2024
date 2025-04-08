<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
$post_type = 'paper';

$args = array(
	'post_type'			=> $post_type,
	'posts_per_page'	=> 6,
	'ignore_row'		=> true,
	'orderby'			=> 'rand',
);

$q = new WP_Query($args);

if ( $q->have_posts() ) { ?>

	<div class="wrapper papers" id="wrapper-papers">

		<div class="slick-carousel">

			<?php while ( $q->have_posts() ) { $q->the_post();

				echo '<div class="slick-item">';

					echo '<div class="card card-body mb-3">';

						printf( '<p class="h6"><a href="%s">%s</a></p>', esc_url( get_permalink() ), get_the_title() );

					echo '</div>';

				echo '</div>';

			} ?>

		</div>

	</div>

<?php }

wp_reset_postdata();