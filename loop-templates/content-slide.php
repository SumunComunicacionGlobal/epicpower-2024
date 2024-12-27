<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$bg_class = 'has-black-background-color';
if ( has_post_thumbnail() ) {
	$bg_class = 'has-black-background-color has-background-dim-80 has-background-dim';
}
?>

<div>

	<div <?php post_class( 'wp-block-cover alignfull' ); ?> id="post-<?php the_ID(); ?>">

		<span aria-hidden="true" class="wp-block-cover__background <?php echo $bg_class; ?>"></span>

		<?php the_post_thumbnail( 'full', array( 'class' => 'wp-block-cover__image-background' ) ); ?>

		<div class="wp-block-cover__inner-container">

			<div class="mw-600">

				<?php the_content(); ?>

			</div>

			<footer class="entry-footer">

				<?php understrap_edit_post_link(); ?>

			</footer><!-- .entry-footer -->

		</div>


	</div><!-- #post-## -->

</div>