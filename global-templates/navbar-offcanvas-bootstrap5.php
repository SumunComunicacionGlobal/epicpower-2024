<?php
/**
 * Header Navbar (bootstrap5)
 *
 * @package Understrap
 * @since 1.1.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = 'container';
$navbar_class = smn_get_navbar_class();
?>

<nav id="main-nav" class="navbar d-block navbar-expand-lg <?php echo $navbar_class; ?>" aria-labelledby="main-nav-label">

	<h2 id="main-nav-label" class="screen-reader-text">
		<?php esc_html_e( 'Main Navigation', 'understrap' ); ?>
	</h2>


	<div class="<?php echo esc_attr( $container ); ?> main-nav-container-1">

		<!-- Your site branding in the menu -->
		<?php get_template_part( 'global-templates/navbar-branding' ); ?>

		<button
			class="navbar-toggler"
			type="button"
			data-bs-toggle="offcanvas"
			data-bs-target="#navbarNavOffcanvas"
			aria-controls="navbarNavOffcanvas"
			aria-expanded="false"
			aria-label="<?php esc_attr_e( 'Open menu', 'understrap' ); ?>"
		>
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="d-none d-lg-flex navbar-right navbar-nav gap-2 align-items-center">

			<?php dynamic_sidebar( 'top-bar' ); ?>

		</div>

	</div><!-- .container(-fluid) -->


	<div class="offcanvas offcanvas-bottom bg-dark" tabindex="-1" id="navbarNavOffcanvas">

		<div class="offcanvas-header justify-content-between">
			
			<div class="nav-link fw-bold text-white"><?php echo get_bloginfo( 'name' ); ?></div>

			<button
				class="btn-close btn-close-white text-reset"
				type="button"
				data-bs-dismiss="offcanvas"
				aria-label="<?php esc_attr_e( 'Close menu', 'understrap' ); ?>"
			></button>

		</div><!-- .offcancas-header -->

		<div class="offcanvas-body main-nav-container-2">

			<!-- The WordPress Menu goes here -->
			<?php
			wp_nav_menu(
				array(
					'theme_location'  => 'primary',
					'container_class' => 'container flex-grow-1 align-items-center',
					'container_id'    => '',
					'menu_class'      => 'navbar-nav flex-grow-1 mb-4 mb-lg-0',
					'fallback_cb'     => '',
					'menu_id'         => 'main-menu',
					'depth'           => 2,
					'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
				)
			);
			?>

			<div class="d-lg-none navbar-right flex-column-reverse navbar-nav gap-2">

				<?php dynamic_sidebar( 'top-bar' ); ?>

			</div>

		</div>

	</div><!-- .offcanvas -->

</nav><!-- #main-nav -->
