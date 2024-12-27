<?php
/**
 * The right sidebar containing the main widget area.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( !is_singular( 'job_offer' ) && !is_active_sidebar( 'right-sidebar' ) ) {
	return;
}

// when both sidebars turned on reduce col size to 3 from 4.
$sidebar_pos = get_theme_mod( 'understrap_sidebar_position' );
$col_class = 'col-md-3';

if ( is_singular( 'job_offer' ) ) {
	$col_class = 'col-md-4';
}
?>

<div class="<?php echo $col_class; ?> widget-area" id="right-sidebar" role="complementary">

	<div class="sticky-sidebar">

		<div class="sidebar__inner">

			<?php if ( is_singular( 'job_offer' ) ) {
				dynamic_sidebar( 'job-offer' ); 
			} else {
				dynamic_sidebar( 'right-sidebar' ); 
			} ?>

		</div>

	</div>

</div><!-- #right-sidebar -->
