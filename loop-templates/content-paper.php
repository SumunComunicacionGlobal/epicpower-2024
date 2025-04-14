<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$paper_categories = get_the_terms( get_the_ID(), 'paper_category' );
?>

<article <?php post_class( 'card' ); ?> id="post-<?php the_ID(); ?>">

	<div class="card-header bg-primary-200">

		<header class="entry-header">
			<?php
			the_title( '<h2 class="h5 mb-0 text-white entry-title">', '</h2>' );
			?>

			<?php if ( 'post' == get_post_type() ) : ?>
				<div class="entry-meta">
					<?php understrap_posted_on(); ?>
				</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->

	</div>

	<div class="card-body py-4">

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

				<?php
				if ( ! empty( $paper_categories ) && ! is_wp_error( $paper_categories ) ) {
					echo '<p class="paper-categories">';
					foreach ( $paper_categories as $category ) {
						echo '<span class="badge bg-light text-dark me-1">' . esc_html( $category->name ) . '</span>';
					}
					echo '</p>';
				}				
				?>

				<div class="entry-content small">
					<?php the_content(); ?>
				</div><!-- .entry-content -->

				<footer class="entry-footer">
					<?php understrap_entry_footer(); ?>
				</footer><!-- .entry-footer -->

			</div>

		</div>

	</div>

</article><!-- #post-## -->
