<?php
/**
 * Navbar branding
 *
 * @package Understrap
 * @since 1.2.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! has_custom_logo() ) { ?>

	<?php 
	$logo_path = get_stylesheet_directory() . '/img/logo-epic-full-color.svg';

	if ( file_exists( $logo_path ) ) : ?>
		
		<a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url">
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo-epic-full-color.svg" alt="<?php __( 'Epic Power logo', 'smn' ); ?>">
		</a>

	<?php else : ?>

		<?php if ( is_front_page() && is_home() ) : ?>

			<h1 class="navbar-brand mb-0">
				<a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url">
					<?php bloginfo( 'name' ); ?>
				</a>
			</h1>

		<?php else : ?>

			<a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url">
				<?php bloginfo( 'name' ); ?>
			</a>

		<?php endif; ?>

	<?php endif; ?>

	<?php
} else {
	the_custom_logo();
}
