<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class( 'card card-body' ); ?> id="post-<?php the_ID(); ?>">

	<div class="row">

		<div class="col-auto mb-2">
			<?php 
			if ( has_post_thumbnail() ) {
				echo get_the_post_thumbnail( null, 'medium', array( 'class' => 'paper-thumbnail img-fluid' ) );
			} else {
				echo '<img src="' . get_stylesheet_directory_uri() . '/img/icono-documento.svg" class="paper-thumbnail img-fluid" alt="'.__( 'Document icon', 'epicpower' ).'">';
			}
			?>
		</div>

		<div class="col">
			<header class="entry-header">
				<?php
				the_title( '<h2 class="h5 entry-title">', '</h2>' );
				?>

				<?php if ( 'post' == get_post_type() ) : ?>
					<div class="entry-meta">
						<?php understrap_posted_on(); ?>
					</div><!-- .entry-meta -->
				<?php endif; ?>
			</header><!-- .entry-header -->

			<div class="entry-content small">
				<?php the_content(); ?>
			</div><!-- .entry-content -->

			<footer class="entry-footer">
				<?php understrap_entry_footer(); ?>
			</footer><!-- .entry-footer -->
		</div>

	</div>

</article><!-- #post-## -->
