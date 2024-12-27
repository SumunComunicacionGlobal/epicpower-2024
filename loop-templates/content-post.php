<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$post_type = get_post_type();
$pt_obj = get_post_type_object( $post_type );
$nombre = $pt_obj->labels->name;
$archive_link = get_post_type_archive_link( $post_type );
?>

<footer class="entry-footer">

	<?php understrap_entry_footer(); ?>

</footer><!-- .entry-footer -->

<article <?php post_class('noticia stretch-linked-block ' . ANIMATION_CLASS ); ?> id="post-<?php the_ID(); ?>">

	<?php if ( 'post' == $post_type ) echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

	<div class="noticia-content-wrapper">

		<header class="entry-header">

			<p class="post-type-name"><?php echo $nombre; ?></p>
			
			<?php if ( 'post' == get_post_type() ) : ?>

				<div class="entry-meta">
					<?php understrap_posted_on(); ?>
				</div><!-- .entry-meta -->

			<?php endif; ?>

			<?php
			the_title(
				sprintf( '<h2 class="entry-title mb-0"><a class="stretched-link" href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
				'</a></h2>'
			);
			?>

		</header><!-- .entry-header -->

		<div class="entry-content">

			<?php if ( 'post' != $post_type ) the_excerpt(); ?>

			<?php
			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
					'after'  => '</div>',
				)
			);
			?>

		</div><!-- .entry-content -->

	</div>

</article><!-- #post-## -->
