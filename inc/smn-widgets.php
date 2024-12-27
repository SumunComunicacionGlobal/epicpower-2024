<?php
/**
 * Declaring widgets
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

add_action( 'widgets_init', 'epicpower_widgets_init', 20 );
function epicpower_widgets_init() {
  
    register_sidebar(
        array(
            'name'          => __( 'Barra lateral en Ofertas de Empleo', 'undesmn-adminstrap' ),
            'id'            => 'job-offer',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div><!-- .widget -->',
            'before_title'  => '<p class="widget-title">',
            'after_title'   => '</p>',
        )
    );
    
    register_sidebar(
        array(
            'name'          => __( 'Autocandidatura Ofertas de Empleo', 'smn-admin' ),
            'id'            => 'job-offers-content',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div><!-- .widget -->',
            'before_title'  => '<p class="widget-title">',
            'after_title'   => '</p>',
        )
    );
    
    register_sidebar(
        array(
            'name'          => __( 'Footer Productos (deprecado)', 'smn-admin' ),
            'id'            => 'footer-product',
            'description'   => __( 'Aparece al final del contenido de los productos, antes de las descargas. Puedes mostrarlo también en una página si activas el check correspondiente ("Mostrar footer de productos")', 'understrap' ),
            'before_widget' => '<div class="dynamic-classes animado"><div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div></div><!-- .footer-widget -->',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );

    register_sidebar(
        array(
            'name'          => __( 'Footer certificaciones', 'smn-admin' ),
            'id'            => 'footer-certifications',
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div><!-- .footer-widget -->',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );

    register_sidebar(
        array(
            'name'          => __( 'Footer newsletter', 'smn-admin' ),
            'id'            => 'footer-newsletter',
            'description'   => __( 'Para insertar formulario newsletter', 'understrap' ),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div><!-- .footer-widget -->',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );

    register_sidebar(
        array(
            'name'          => __( 'Copyright', 'smn-admin' ),
            'id'            => 'copyright',
            'description'   => __( 'Full sized footer widget with dynamic grid', 'understrap' ),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s dynamic-classes">',
            'after_widget'  => '</div><!-- .footer-widget -->',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );

    register_sidebar(
        array(
            'name'          => __( 'Modal formulario Request a Quote', 'smn-admin' ),
            'id'            => 'modal-quote-form',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div><!-- .widget -->',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );

    register_sidebar(
        array(
            'name'          => __( 'Modal formulario de contacto', 'smn-admin' ),
            'id'            => 'modal-contact-form',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div><!-- .widget -->',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );

    register_sidebar(
        array(
            'name'          => __( 'Menú widgets', 'smn-admin' ),
            'id'            => 'menu-idioma',
            'description'   => __( 'Aparecen en el menú principal, bajo el selector de idioma de WPML si está activo', 'understrap' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div><!-- .widget -->',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );

    register_sidebar(
        array(
            'name'          => __( 'Converters sizes guide', 'smn-admin' ),
            'id'            => 'converters-sizes-guide',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div><!-- .widget -->',
            'before_title'  => '<p class="widget-title">',
            'after_title'   => '</p>',
        )
    );

}
/***/

/* Site info */
add_action( 'understrap_site_info', 'understrap_add_site_info' );

/**
 * Add site info content.
 */
function understrap_add_site_info() {
    if (is_active_sidebar( 'copyright' )) {
        echo '<div class="row">';
            dynamic_sidebar( 'copyright' );
        echo '</div>';
    }
}

/***/

function understrap_widgets_init() {
	
	register_sidebar(
		array(
			'name'          => __( 'Top bar', 'understrap' ),
			'id'            => 'top-bar',
			'description'   => __( 'Top bar widget area', 'understrap' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<p class="widget-title">',
			'after_title'   => '</p>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Right Sidebar', 'understrap' ),
			'id'            => 'right-sidebar',
			'description'   => __( 'Right sidebar widget area', 'understrap' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<p class="widget-title">',
			'after_title'   => '</p>',
		)
	);

    register_sidebar(
        array(
            'name'          => __( 'Pre footer', 'understrap' ),
            'id'            => 'prefooter',
            'description'   => __( 'Aparece antes del Pie de Página Completo', 'understrap' ),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div><!-- .footer-widget -->',
            'before_title'  => '<p class="widget-title">',
            'after_title'   => '</p>',
        )
    );

	register_sidebar(
		array(
			'name'          => __( 'Footer Full', 'understrap' ),
			'id'            => 'footerfull',
			'description'   => __( 'Full sized footer widget with dynamic grid', 'understrap' ),
			'before_widget' => '<div id="%1$s" class="footer-widget %2$s dynamic-classes">',
			'after_widget'  => '</div><!-- .footer-widget -->',
			'before_title'  => '<p class="widget-title">',
			'after_title'   => '</p>',
		)
	);

}

