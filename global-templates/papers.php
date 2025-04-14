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

if ( $q->have_posts() ) { 
	
	// $post_type_label = get_post_type_object( $post_type )->labels->singular_name;
	$icono = '<img src="' . get_stylesheet_directory_uri() . '/img/icono-documento.svg" class="paper-thumbnail img-fluid" alt="'.__( 'Document icon', 'epicpower' ).'">';
	?>

	<div class="wrapper papers" id="wrapper-papers">

		<div class="slick-carousel">

			<?php while ( $q->have_posts() ) { $q->the_post();

				echo '<div class="slick-item">';

					echo '<div class="card mb-3 card-'. $post_type .'">';

						echo '<div class="card-body card-body-faded">';

							echo $icono;

							printf( '<p class="h6"><a class=" stretched-link" href="%s">%s</a></p>', esc_url( get_permalink() ), get_the_title() );

							echo '<div class="small text-muted">';
								the_content();
							echo '</div>';

						echo '</div>';

					echo '</div>';

				echo '</div>';

			} ?>
			
			<?php
			echo '<div class="slick-item">';
				echo '<div class="card card-'. $post_type .' mb-3 bg-primary-200">';
					echo '<div class="card-body">';
						printf( '<p class="h5"><a class="stretched-link text-white" href="%s">%s</a></p>', esc_url( get_post_type_archive_link( $post_type ) ), 'View all Papers' );
					echo '</div>';
				echo '</div>';
			echo '</div>';
			?>

		</div>

	</div>

<?php }

wp_reset_postdata();