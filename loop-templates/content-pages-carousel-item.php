<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$show_excerpt = isset( $args['show_excerpt'] ) ? $args['show_excerpt'] : true;
$show_image = isset( $args['show_image'] ) ? $args['show_image'] : true;
$color_scheme = isset( $args['color_scheme'] ) ? $args['color_scheme'] : 'light';

$title = get_the_title();

$background_color_class = 'has-light-background-color';
$cover_class = 'is-light';
if ( 'dark' === $color_scheme ) {
	$background_color_class = 'has-primary-200-background-color';
	$cover_class = 'is-dark';
}

$background_dim_class = 'has-background-dim-100';
if ( $show_image && has_post_thumbnail() ) {
	$background_dim_class = 'has-background-dim-90';
	$cover_class .= ' has-image-background';
}

$icono = get_post_meta( get_the_ID(), 'icono', true );
$icono = ($icono) ? '<div class="infografia-home-icono">'.wp_get_attachment_image( $icono, 'medium' ).'</div>' : '';


?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<?php // the_post_thumbnail( 'medium_large' ); ?>

	<div class="wp-block-cover case-study-cover stretch-linked-block <?php echo $cover_class; ?>">

		<?php if ( $show_image && has_post_thumbnail() ) {
			the_post_thumbnail( 'medium_large', ['class' => 'wp-block-cover__image-background'] );
		} ?>

		<span class="wp-block-cover__background has-background-dim <?php echo esc_attr( $background_color_class . ' ' . $background_dim_class ); ?>" aria-hidden="true"></span>

		<div class="wp-block-cover__inner-container">

			<div class="post-type-label"><?php echo $icono; ?></div>

			<div class="wp-block-cover__content">
			
				<header class="entry-header">

					<h3 class="h4 entry-title"><a class="stretched-link" href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php echo $title; ?></a></h3>

				</header><!-- .entry-header -->

				<?php if ( $show_excerpt && has_excerpt() ) : ?>
					<div class="entry-content">
						<?php echo wpautop( $post->post_excerpt ); ?>
					</div>
				<?php endif; ?>

				<footer class="entry-footer">

					<?php understrap_entry_footer(); ?>

				</footer><!-- .entry-footer -->

			</div>

		</div>

	</div>

</article><!-- #post-## -->
