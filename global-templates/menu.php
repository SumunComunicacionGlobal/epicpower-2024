<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
$menu_desplegado = get_post_meta( get_the_ID(), 'mostrar_menu_desplegado', true );
$class_menu_desplegado = ($menu_desplegado && 1 == $menu_desplegado) ? 'desplegado-menu-fase-1 predesplegado' : '';
?>

<!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'understrap' ); ?>">
	<span class="navbar-toggler-icon"></span>
</button> -->

<div id="menu-principal" class="<?php echo $class_menu_desplegado; ?>">


		<div id="menu-fase-1" class="menu-fase">

			<div class="wrapper">

				<?php wp_nav_menu(
					array(
						'theme_location'  => 'menu_fase_1',
						'depth'           => 1,
						'container'			=> false,
					)
				); ?>

			</div>

		</div>

		<div id="menu-fase-2" class="menu-fase">

			<div class="wrapper">

				<div class="wrapper-menu">

					<a href="#" class="mostrar-buscador"><i class="fa fa-search"></i></a>


					<?php wp_nav_menu(
						array(
							'theme_location'  => 'menu_fase_2',
							'depth'           => 1,
						)
					); ?>

					<?php echo get_redes_sociales(); ?>

				</div>

				<div class="wrapper-wpml">

					<?php do_action( 'wpml_language_switcher' ); ?>

					<?php if ( is_active_sidebar( 'menu-idioma' )) {
						dynamic_sidebar( 'menu-idioma' );
					} ?>

				</div>

			</div>

		</div>

		<div id="menu-movil" class="menu-fase">

			<div class="wrapper">

				<a href="#" class="mostrar-buscador"><i class="fa fa-search"></i></a>

				<div class="menu-movil-elemento-central text-white">

					<?php wp_nav_menu(
						array(
							'theme_location'  => 'movil',
							'depth'           => 1,
						)
					); ?>

					<?php do_action( 'wpml_language_switcher' ); ?>

					<?php if ( is_active_sidebar( 'menu-idioma' )) {
						dynamic_sidebar( 'menu-idioma' );
					} ?>

				</div>

				<?php echo get_redes_sociales(); ?>

			</div>

		</div>

		<div id="buscador" class="menu-fase">

			<div class="wrapper">

				<p class="search-form-header"><?php _e( 'Find your product here', 'epicpower' ); ?></p>
				<?php get_search_form(); ?>

			</div>

		</div>

		<!-- <a href="#" class="cerrar-menu">

			[x]

		</a> -->

		<?php epicpower_menu_toggler(); ?>


</div>


<script>
	var menuPrincipal = jQuery('#menu-principal');
	jQuery('.mostrar-buscador').click( function(e) {
		e.preventDefault();
		menuPrincipal.toggleClass('desplegado-buscador');
		jQuery('#buscador input#s').focus();
	});
	jQuery('.epicpower-menu-toggler').click( function(e) {
		e.preventDefault();

		if( jQuery(this).hasClass('cerrar')) {
			menuPrincipal.removeClass('desplegado-buscador');
		}

		esMovil = false;
		if (jQuery('#menu-movil').css('display') != 'none') {
			esMovil = true;
		}

		if(esMovil) {
			jQuery(this).toggleClass('izq cerrar');
			menuPrincipal.toggleClass('desplegado-menu-movil');
		} else {
			if(menuPrincipal.hasClass('desplegado-menu-fase-1')) {
				menuPrincipal.toggleClass('desplegado-menu-fase-1 desplegado-menu-fase-2');
				jQuery(this).toggleClass('izq cerrar');
			} else if(menuPrincipal.hasClass('desplegado-menu-fase-2')) {
				menuPrincipal.toggleClass('desplegado-menu-fase-2');
				jQuery(this).toggleClass('izq cerrar');
			} else {
				// menuPrincipal.toggleClass('desplegado-menu-fase-1');
				menuPrincipal.toggleClass('desplegado-menu-fase-2');
				jQuery(this).toggleClass('izq cerrar');
			}

		}
	});

</script>