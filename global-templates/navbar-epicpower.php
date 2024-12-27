<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
$navbar_class = smn_get_navbar_class();
?>

<nav class="navbar navbar-epicpower <?php echo $navbar_class; ?>">

<?php if ( 'container' == $container ) : ?>
    <div class="container">
<?php endif; ?>

            <!-- Your site title as branding in the menu -->
            <?php if ( ! has_custom_logo() ) { ?>

                <a href="<?php echo get_home_url(); ?>" class="navbar-brand custom-logo-link default-logo" rel="home">
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/img/logo-epic-blanco.svg" class="img-fluid logo-inicial" alt="<?php bloginfo('name'); ?>">
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/img/logo-epic-full-color.svg" class="img-fluid logo-scrolled" alt="<?php bloginfo('name'); ?>">
                </a> 

            <?php } else {
                the_custom_logo();
            } ?><!-- end custom logo -->

            <?php get_template_part( 'global-templates/menu' ); ?>

    <?php if ( 'container' == $container ) : ?>
    </div><!-- .container -->
    <?php endif; ?>

</nav><!-- .site-navigation -->
