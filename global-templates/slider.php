<?php
/**
 * Hero setup.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<?php $page_video_url = get_post_meta( get_the_ID(), 'url_video_cabecera', true ); ?>

<?php
$args = array(
	'post_type'			=> 'slide',
	'posts_per_page'	=> -1,
	'orderby'			=> 'menu_order',
	'order'				=> 'ASC',

);

$q = new WP_Query($args);

if ($q->have_posts()) {

	$indicators = '';

	echo '<div id="slider-home" class="carousel slide" data-bs-ride="carousel" data-bs-interval="7000">';
		echo '<div class="carousel-inner">';

			if($page_video_url) {
				video_background($page_video_url);
			}

			while( $q->have_posts() ) {
				$q->the_post();
				$slide_actual = $q->current_post;
				$class_active = '';
				if ($slide_actual == 0) {
					$class_active = 'active';
				}

				$link_before = '';
				$link_after = '';
				$linked_block_class = '';

				$link_id = get_post_meta( get_the_ID(), 'link', true );
				if ( $link_id ) {
					$link_before = '<a class="block-link" href="' . get_the_permalink( $link_id ) . '" title="'.get_the_title( $link_id ).'">';
					$link_after = '</a>';
					$linked_block_class = 'linked-block';
				}

				$style = '';
				if(!$page_video_url || wp_is_mobile() ) {
					$bg_url = get_the_post_thumbnail_url( null, 'large' );
					$style .= 'style="background-image:url('.$bg_url.');"';
				}

				echo '<div class="carousel-item bg-cover '.$class_active.'" '.$style.'>';

					echo '<div class="slide-wrapper">';
						echo '<div class="container">';
							echo '<div class="slide-content-wrapper">';
									// the_title( '<p class="slide-title">', '</p>');
									echo '<div class="slide-content '.$linked_block_class.'">';
										the_content();
									echo $link_before . $link_after;
									echo '</div>';
							echo '</div>';
						echo '</div>';
					echo '</div>';

				echo '</div>';

				// $indicators .= '<li data-bs-target="#slider-home" data-bs-slide-to="'.$slide_actual.'" class="'.$class_active.'"></li>';

				echo '<div class="scroll-button-wrapper"><div class="container"><a class="scroll-button" href="#content" title="'.__( 'Scroll to content', 'epicpower' ).'"></a></div></div>';
			}

		echo '</div>';
		
		if ( '' != $indicators ) echo '<ol class="carousel-indicators">'.$indicators.'</ol>';
		/* echo '  <a class="carousel-control-prev" href="#slider-home" role="button" data-bs-slide="prev">
			    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
			    <span class="sr-only">Previous</span>
			  </a>
			  <a class="carousel-control-next" href="#slider-home" role="button" data-bs-slide="next">
			    <span class="carousel-control-next-icon" aria-hidden="true"></span>
			    <span class="sr-only">Next</span>
			  </a>'; */

		// echo do_shortcode( '[el_tiempo]' );

	echo '</div>';

}

wp_reset_postdata();
