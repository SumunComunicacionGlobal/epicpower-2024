<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$bg_class = 'has-black-background-color';
if ( has_post_thumbnail() ) {
	$bg_class = 'has-black-background-color has-background-dim-0 has-background-dim';
}
?>


<div <?php post_class( '' ); ?> id="post-<?php the_ID(); ?>">


		<div class="mw-600 text-white">

			<?php the_content(); ?>

		</div>

		<footer class="entry-footer">

			<?php understrap_edit_post_link(); ?>

		</footer><!-- .entry-footer -->


</div><!-- #post-## -->

