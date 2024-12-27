<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class( 'hfeed-post' ); ?> id="post-<?php the_ID(); ?>">

	<div class="row">

		<div class="col-3">

			<?php echo get_the_post_thumbnail( $post->ID, 'thumbnail', array( 'class' => 'rounded-circle' ) ); ?>

		</div>

		<div class="col-9">

			<div class="entry-content">

				<?php
				the_content();
				?>

			</div><!-- .entry-content -->

			<footer class="entry-footer">

				<?php
				the_title(
					sprintf( '<h2 class="h5 entry-title"><a class="stretched-link" href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
					'</a></h2>'
				);
				?>

				<?php if ( $post->post_excerpt ) {
					echo '<p class="small text-uppercase">' . $post->post_excerpt . '</p>';
				} ?>

				<?php understrap_entry_footer(); ?>

			</footer><!-- .entry-footer -->

		</div>

	</div>

</article><!-- #post-## -->
