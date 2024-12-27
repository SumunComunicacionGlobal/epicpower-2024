<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
$post_meta = get_post_meta( get_the_ID() );
$cargo = (isset($post_meta['cargo'])) ? $post_meta['cargo'][0] : false;
?>

<article <?php post_class('card'); ?> id="post-<?php the_ID(); ?>">

	<?php echo get_the_post_thumbnail( $post->ID, 'large', array('class' => 'card-img-top mb-3') ); ?>

	<div class="card-body">

			<?php the_title( '<h5 class="card-title">', '</h5>' ); ?>

		<div class="card-text">

			<?php
			$more = ($post->post_excerpt) ? ' <a class="more-collapse" data-bs-toggle="collapse" href="#bio-'.$post->ID.'" role="button" aria-expanded="false" aria-controls="bio-'.$post->ID.'">[+]</a>' : '';
			if ($cargo) echo '<p class="cargo">'.$cargo.$more. '</p>';
			foreach ( $post_meta as $key => $value ) {
				if ($value[0]) {
					$link = $value[0];
					if ( substr($key, 0, 9) === 'contacto_' ) {
						$icon_key = substr($key, 9, strlen($key));
						if( 'envelope' == $icon_key ) $link = 'mailto:' . $link;
						echo '<a href="'.$link.'" target="_blank"><i class="fa fa-'.$icon_key.' icono-contacto"></i></a>';
					}
				}
			}

			if($post->post_excerpt) echo '<div class="bio collapse" id="bio-'.$post->ID.'">' . wpautop( $post->post_excerpt ) . '</div>';
			?>

		</div><!-- .entry-content -->

	</div>

</article><!-- #post-## -->
