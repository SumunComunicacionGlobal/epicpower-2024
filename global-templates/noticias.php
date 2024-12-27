<?php

$mostrar_noticias = get_post_meta( get_the_ID(), 'mostrar_noticias', true );

if ($mostrar_noticias == 1) {

	$args = array(
		'post_type'				=> array('post', 'case_study'),
		'posts_per_page'		=> 12
	);

	$q = new WP_Query($args); ?>

	<?php if ( $q->have_posts() ) { ?>

		<section class="wrapper pt-0" id="seccion-noticias">

			<div class="container">

				<!-- <div class="row noticias mb-5"> -->
				<div class="slick-carousel">

					<?php while ( $q->have_posts() ) { $q->the_post(); ?>
						
						<!-- <div class="col-md-6 col-lg-3 mb-4 animado"> -->
						<div class="slick-item">

							<?php get_template_part( 'loop-templates/content', get_post_type() ); ?>

						</div>

					<?php } ?>

				</div>

				<div class="d-flex justify-content-between">

					<?php
					$noticias_id = get_option( 'page_for_posts' );
					if ($noticias_id) {
						// $titulo = get_the_title( $noticias_id );
						$titulo = __( 'News & Case Studies', 'epicpower' );
						echo '<a class="link-plus text-uppercase" href="'.get_the_permalink( $noticias_id ).'" title="'.$titulo.'">'.$titulo.'</a>';
					}
					?>

				</div>

			</div>

		</section>

	<?php } ?>

	<?php wp_reset_postdata(); ?>

<?php } ?>