<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class( 'p-4 p-md-5 mb-3 border border-light bg-light'); ?> id="post-<?php the_ID(); ?>">

	<div class="row align-items-center">

		<div class="col-md-8 col-lg-9">

			<header class="entry-header">

				<?php
				the_title(
					sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
					'</a></h2>'
				);
				?>

				<?php if ( 'post' == get_post_type() ) : ?>

					<div class="entry-meta">
						<?php understrap_posted_on(); ?>
					</div><!-- .entry-meta -->

				<?php endif; ?>

			</header><!-- .entry-header -->

			<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

			<div class="entry-content">

				<?php the_excerpt(); ?>

				<?php
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
						'after'  => '</div>',
					)
				);
				?>

			</div><!-- .entry-content -->

			<footer class="entry-footer">

				<?php understrap_entry_footer(); ?>

			</footer><!-- .entry-footer -->

		</div>

		<div class="col-md-4 col-lg-3 text-center">

				<a href="<?php echo get_permalink(); ?>" class="btn btn-outline-primary"><?php _e( 'Ver oferta', 'smn' ); ?></a>

		</div>

	</div>

</article><!-- #post-## -->
