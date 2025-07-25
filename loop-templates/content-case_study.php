<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$title = get_the_title();
$post_type_label = get_post_type_object( get_post_type() )->labels->singular_name;

$background_class = 'has-background-dim-100';
if ( has_post_thumbnail() ) {
	$background_class = 'has-background-dim-70';
}
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<div class="wp-block-cover case-study-cover">

		<span class="wp-block-cover__background has-primary-600-background-color has-background-dim <?php echo esc_attr( $background_class ); ?>" aria-hidden="true"></span>

		<?php the_post_thumbnail( 'medium_large', array( 'class' => 'wp-block-cover__image-background' ) ); ?>

		<div class="wp-block-cover__inner-container">

			<p class="post-type-label text-white"><?php echo esc_html( $post_type_label ); ?></p>

			<div class="wp-block-cover__content">
			
				<header class="entry-header">

					<p class="h4 entry-title text-white"><a class="stretched-link" href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php echo $title; ?></a></p>

				</header><!-- .entry-header -->

				<?php if ( has_excerpt() ) : ?>
					<div class="entry-content">
						<?php echo wpautop( $post->post_excerpt ); ?>
					</div>
				<?php endif; ?>

				<footer class="entry-footer text-white">

					<?php understrap_entry_footer(); ?>

				</footer><!-- .entry-footer -->

			</div>

		</div>

	</div>

</article><!-- #post-## -->
