<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$title = get_the_title();
$title_array = explode( '&#8211;', $title );

if ( count( $title_array ) > 1 ) {
	$title_code = $title_array[0];
	$title = $title_array[1];
}

$background_class = 'has-background-dim-100';
if ( has_post_thumbnail() ) {
	$background_class = 'has-background-dim-80';
}
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<div class="wp-block-cover application-note-cover stretch-linked-block">

		<span class="wp-block-cover__background has-primary-200-background-color has-background-dim <?php echo esc_attr( $background_class ); ?>" aria-hidden="true"></span>

		<?php the_post_thumbnail( 'medium_large', array( 'class' => 'wp-block-cover__image-background' ) ); ?>

		<div class="wp-block-cover__inner-container">

			<header class="entry-header">

				<?php
				if ( isset( $title_code ) ) {
					echo '<p class="display-4 mb-4">' . esc_html( $title_code ) . '</p>';
				}
				?>

				<h3 class="entry-title text-white"><a class="stretched-link" href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark" target="_blank"><?php echo $title; ?></a></h3>

			</header><!-- .entry-header -->

			<footer class="entry-footer text-white">

				<?php understrap_entry_footer(); ?>

			</footer><!-- .entry-footer -->

		</div>

	</div>

</article><!-- #post-## -->
