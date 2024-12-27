<?php
/**
 * Sidebar setup for footer full.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );

?>

<?php if ( is_active_sidebar( 'footerfull' ) || is_active_sidebar( 'footer-newsletter' ) ) : ?>

	<!-- ******************* The Footer Full-width Widget Area ******************* -->

	<div class="wrapper" id="wrapper-footer-full">

		<div class="<?php echo esc_attr( $container ); ?>" id="footer-full-content" tabindex="-1">

			<?php if ( is_active_sidebar( 'footer-certifications' ) ) { ?>

				<div class="wrapper" id="wrapper-certifications">
					
					<?php dynamic_sidebar( 'footer-certifications' ); ?>

				</div>

			<?php } ?>

			<div class="row mb-5 align-items-end">

				<div class="col-md-8">

					<div class="row">

						<?php dynamic_sidebar( 'footer-newsletter' ); ?>

					</div>

				</div>

				<div class="col-md-4 d-none d-md-block">

					<div class="footer-widget">

						<?php echo get_redes_sociales(); ?>

					</div>

				</div>

			</div>

			<div class="row mb-3">

				<?php dynamic_sidebar( 'footerfull' ); ?>

			</div>

		</div>

	</div><!-- #wrapper-footer-full -->

<?php endif; ?>
