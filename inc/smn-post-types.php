<?php 

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

add_post_type_support( 'page', 'excerpt' );

add_action( 'init', 'epicpower_settings', 1000 );
function epicpower_settings() {  
    // register_taxonomy_for_object_type('category', 'page');  
    register_taxonomy_for_object_type('product_category', 'page');  
    register_taxonomy_for_object_type('industry', 'page');  
}

add_filter( 'sdm_downloads_post_type_before_register', 'smn_modify_sdm_downloads_post_type_before_register' );
function smn_modify_sdm_downloads_post_type_before_register( $args ) {
	$args['show_in_rest'] = true;
	return $args;
}

if ( ! function_exists('custom_post_type_slide') ) {

// Register Custom Post Type
function custom_post_type_slide() {

	$labels = array(
		'name'                  => _x( 'Slides', 'Post Type General Name', 'epicpower' ),
		'singular_name'         => _x( 'Slide', 'Post Type Singular Name', 'epicpower' ),
		'menu_name'             => __( 'Slides', 'epicpower-admin' ),
		'name_admin_bar'        => __( 'Slides', 'epicpower-admin' ),
		'add_new'               => __( 'Añadir nueva Slide', 'epicpower-admin' ),
		'new_item'              => __( 'Nueva Slide', 'epicpower-admin' ),
		'edit_item'             => __( 'Editar Slide', 'epicpower-admin' ),
		'update_item'           => __( 'Actualizar Slide', 'epicpower-admin' ),
		'view_item'             => __( 'Ver Slide', 'epicpower-admin' ),
		'view_items'            => __( 'Ver Slide', 'epicpower-admin' ),
	);
	$args = array(
		'label'                 => __( 'Slides', 'epicpower' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'page-attributes' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 3,
		'menu_icon'             => 'dashicons-slides',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest' 			=> true,
		'taxonomies'			=> array(),
	);
	register_post_type( 'slide', $args );

}
add_action( 'init', 'custom_post_type_slide', 0 );

}


if ( ! function_exists('custom_post_type_portfolio_page') ) {

// Register Custom Post Type
function custom_post_type_portfolio_page() {

	$labels = array(
		'name'                  => _x( 'Proyectos', 'Post Type General Name', 'epicpower' ),
		'singular_name'         => _x( 'Proyecto', 'Post Type Singular Name', 'epicpower' ),
		'menu_name'             => __( 'Proyectos', 'epicpower-admin' ),
		'name_admin_bar'        => __( 'Proyectos', 'epicpower-admin' ),
		'add_new'               => __( 'Añadir nuevo Proyecto', 'epicpower-admin' ),
		'new_item'              => __( 'Nuevo Proyecto', 'epicpower-admin' ),
		'edit_item'             => __( 'Editar Proyecto', 'epicpower-admin' ),
		'update_item'           => __( 'Actualizar Proyecto', 'epicpower-admin' ),
		'view_item'             => __( 'Ver Proyecto', 'epicpower-admin' ),
		'view_items'            => __( 'Ver Proyecto', 'epicpower-admin' ),
		'featured_image'		=> __( 'Imagen principal', 'epicpower-admin' ),
		'set_featured_image'	=> __( 'Establecer Imagen principal', 'epicpower-admin' ),
		'remove_featured_image'	=> __( 'Quitar Imagen principal', 'epicpower-admin' ),
		'use_featured_image'	=> __( 'Usar como Imagen principal', 'epicpower-admin' ),
	);
	$args = array(
		'label'                 => __( 'Proyectos', 'epicpower' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'page-attributes', 'revisions' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-welcome-write-blog',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'taxonomies'			=> array('product_category', 'portfolio_category', 'industry'),
		'show_in_rest'			=> true,
	);
	register_post_type( 'portfolio_page', $args );

}
// add_action( 'init', 'custom_post_type_portfolio_page', 0 );

}


if ( ! function_exists('custom_post_type_case_study') ) {

// Register Custom Post Type
function custom_post_type_case_study() {

	$labels = array(
		'name'                  => _x( 'Case studies', 'Post Type General Name', 'epicpower' ),
		'singular_name'         => _x( 'Case study', 'Post Type Singular Name', 'epicpower' ),
		'menu_name'             => __( 'Case studies', 'epicpower-admin' ),
		'name_admin_bar'        => __( 'Case studies', 'epicpower-admin' ),
		'add_new'               => __( 'Añadir nuevo Case study', 'epicpower-admin' ),
		'new_item'              => __( 'Nuevo Case study', 'epicpower-admin' ),
		'edit_item'             => __( 'Editar Case study', 'epicpower-admin' ),
		'update_item'           => __( 'Actualizar Case study', 'epicpower-admin' ),
		'view_item'             => __( 'Ver Case study', 'epicpower-admin' ),
		'view_items'            => __( 'Ver Case study', 'epicpower-admin' ),
		'featured_image'		=> __( 'Imagen principal', 'epicpower-admin' ),
		'set_featured_image'	=> __( 'Establecer Imagen principal', 'epicpower-admin' ),
		'remove_featured_image'	=> __( 'Quitar Imagen principal', 'epicpower-admin' ),
		'use_featured_image'	=> __( 'Usar como Imagen principal', 'epicpower-admin' ),
	);
	$args = array(
		'label'                 => __( 'Case studies', 'epicpower' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'page-attributes', 'revisions' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-thumbs-up',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => __('case-studies'),
		'rewrite'            	=> array( 'slug' => 'case-study' ),
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'taxonomies'			=> array('product_category', 'portfolio_category', 'industry'),
		'show_in_rest'			=> true,

	);
	register_post_type( 'case_study', $args );

}
add_action( 'init', 'custom_post_type_case_study', 0 );

}


if ( ! function_exists('custom_post_type_product') ) {

// Register Custom Post Type
function custom_post_type_product() {

	$labels = array(
		'name'                  => _x( 'Products', 'Post Type General Name', 'epicpower' ),
		'singular_name'         => _x( 'Product', 'Post Type Singular Name', 'epicpower' ),
		'menu_name'             => __( 'Productos', 'epicpower-admin' ),
		'name_admin_bar'        => __( 'Productos', 'epicpower-admin' ),
		'add_new'               => __( 'Añadir nuevo Producto', 'epicpower-admin' ),
		'new_item'              => __( 'Nuevo Producto', 'epicpower-admin' ),
		'edit_item'             => __( 'Editar Producto', 'epicpower-admin' ),
		'update_item'           => __( 'Actualizar Producto', 'epicpower-admin' ),
		'view_item'             => __( 'Ver Producto', 'epicpower-admin' ),
		'view_items'            => __( 'Ver Producto', 'epicpower-admin' ),
		'featured_image'		=> __( 'Imagen principal', 'epicpower-admin' ),
		'set_featured_image'	=> __( 'Establecer Imagen principal', 'epicpower-admin' ),
		'remove_featured_image'	=> __( 'Quitar Imagen principal', 'epicpower-admin' ),
		'use_featured_image'	=> __( 'Usar como Imagen principal', 'epicpower-admin' ),
	);
	$args = array(
		'label'                 => __( 'Products', 'epicpower' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'page-attributes', 'revisions' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-admin-plugins',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'taxonomies'			=> array('product_category', 'portfolio_category', 'industry'),
		'show_in_rest'			=> true,
	);
	register_post_type( 'product', $args );

}
add_action( 'init', 'custom_post_type_product', 0 );

}

if ( ! function_exists('custom_post_type_team') ) {

// Register Custom Post Type
function custom_post_type_team() {

	$labels = array(
		'name'                  => _x( 'Team members', 'Post Type General Name', 'epicpower' ),
		'singular_name'         => _x( 'Team member', 'Post Type Singular Name', 'epicpower' ),
		'menu_name'             => __( 'Miembro del equipo', 'epicpower-admin' ),
		'name_admin_bar'        => __( 'Miembros del equipo', 'epicpower-admin' ),
		'add_new'               => __( 'Añadir nuevo Miembro del equipo', 'epicpower-admin' ),
		'new_item'              => __( 'Nuevo Miembro del equipo', 'epicpower-admin' ),
		'edit_item'             => __( 'Editar Miembro del equipo', 'epicpower-admin' ),
		'update_item'           => __( 'Actualizar Miembro del equipo', 'epicpower-admin' ),
		'view_item'             => __( 'Ver Miembro del equipo', 'epicpower-admin' ),
		'view_items'            => __( 'Ver Miembro del equipo', 'epicpower-admin' ),
		'featured_image'		=> __( 'Foto', 'epicpower-admin' ),
		'set_featured_image'	=> __( 'Establecer Foto', 'epicpower-admin' ),
		'remove_featured_image'	=> __( 'Quitar Foto', 'epicpower-admin' ),
		'use_featured_image'	=> __( 'Usar como Foto', 'epicpower-admin' ),
	);
	$args = array(
		'label'                 => __( 'Team members', 'epicpower' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-id',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'taxonomies'			=> array(),
	);
	register_post_type( 'team', $args );

}
add_action( 'init', 'custom_post_type_team', 0 );

}

if ( ! function_exists('custom_post_type_job_offer') ) {

// Register Custom Post Type
function custom_post_type_job_offer() {

	$labels = array(
		'name'                  => _x( 'Job Offers', 'Post Type General Name', 'epicpower' ),
		'singular_name'         => _x( 'Job Offer', 'Post Type Singular Name', 'epicpower' ),
		'menu_name'             => __( 'Ofertas de Empleo', 'epicpower-admin' ),
		'name_admin_bar'        => __( 'Ofertas de Empleo', 'epicpower-admin' ),
		'add_new'               => __( 'Añadir nueva Oferta de Empleo', 'epicpower-admin' ),
		'new_item'              => __( 'Nueva Oferta de Empleo', 'epicpower-admin' ),
		'edit_item'             => __( 'Editar Oferta de Empleo', 'epicpower-admin' ),
		'update_item'           => __( 'Actualizar Oferta de Empleo', 'epicpower-admin' ),
		'view_item'             => __( 'Ver Oferta de Empleo', 'epicpower-admin' ),
		'view_items'            => __( 'Ver Ofertas de Empleo', 'epicpower-admin' ),
	);
	$args = array(
		'label'                 => __( 'Job Offers', 'epicpower' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'custom-fields', 'page-attributes' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-businessperson',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => __( 'job-offers', 'smn' ),
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'taxonomies'            => array(),
	);
	register_post_type( 'job_offer', $args );

}
add_action( 'init', 'custom_post_type_job_offer', 0 );

}

if ( ! function_exists('custom_post_type_application_note') ) {

	// Register Custom Post Type
	function custom_post_type_application_note() {
	
		$labels = array(
			'name'                  => _x( 'Application Notes', 'Post Type General Name', 'epicpower' ),
			'singular_name'         => _x( 'Application Note', 'Post Type Singular Name', 'epicpower' ),
			'menu_name'             => __( 'Application Notes', 'epicpower-admin' ),
			'name_admin_bar'        => __( 'Application Notes', 'epicpower-admin' ),
			'add_new'               => __( 'Añadir nueva Application Note', 'epicpower-admin' ),
			'new_item'              => __( 'Nueva Application Note', 'epicpower-admin' ),
			'edit_item'             => __( 'Editar Application Note', 'epicpower-admin' ),
			'update_item'           => __( 'Actualizar Application Note', 'epicpower-admin' ),
			'view_item'             => __( 'Ver Application Note', 'epicpower-admin' ),
			'view_items'            => __( 'Ver Application Note', 'epicpower-admin' ),
		);
		$args = array(
			'label'                 => __( 'Application Notes', 'epicpower' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'custom-fields', 'page-attributes' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-media-document',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => __( 'application-notes', 'smn' ),
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
			'show_in_rest'          => true,
			'taxonomies'            => array(),
		);
		register_post_type( 'application_note', $args );
	
	}
	add_action( 'init', 'custom_post_type_application_note', 0 );
	
	}
	

if ( ! function_exists('custom_post_type_video_tutorial') ) {

	// Register Custom Post Type
	function custom_post_type_video_tutorial() {
	
		$labels = array(
			'name'                  => _x( 'Video tutorials', 'Post Type General Name', 'epicpower' ),
			'singular_name'         => _x( 'Video tutorial', 'Post Type Singular Name', 'epicpower' ),
			'menu_name'             => __( 'Video tutorials', 'epicpower-admin' ),
			'name_admin_bar'        => __( 'Video tutorials', 'epicpower-admin' ),
			'add_new'               => __( 'Añadir nuevo Video tutorial', 'epicpower-admin' ),
			'new_item'              => __( 'Nuevo Video tutorial', 'epicpower-admin' ),
			'edit_item'             => __( 'Editar Video tutorial', 'epicpower-admin' ),
			'update_item'           => __( 'Actualizar Video tutorial', 'epicpower-admin' ),
			'view_item'             => __( 'Ver Video tutorial', 'epicpower-admin' ),
			'view_items'            => __( 'Ver Video tutoriales', 'epicpower-admin' ),
		);
		$args = array(
			'label'                 => __( 'Video tutorials', 'epicpower' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'custom-fields', 'page-attributes' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-video-alt',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => false,
			'can_export'            => true,
			'has_archive'           => __( 'video-tutorials', 'smn' ),
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
			'show_in_rest'          => true,
			'taxonomies'            => array(),
		);
		register_post_type( 'video_tutorial', $args );
	
	}
	add_action( 'init', 'custom_post_type_video_tutorial', 0 );
	
	}

if ( ! function_exists( 'portfolio_category_custom_taxonomy' ) ) {

// Register Custom Taxonomy
function portfolio_category_custom_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Portfolio Categories', 'Taxonomy General Name', 'epicpower' ),
		'singular_name'              => _x( 'Portfolio Category', 'Taxonomy Singular Name', 'epicpower' ),
		'menu_name'                  => __( 'Categorías de Portfolio', 'epicpower' ),
		'all_items'                  => __( 'Todas las Categorías de Portfolio', 'epicpower' ),
		'parent_item'                => __( 'Categoría de Portfolio superior', 'epicpower' ),
		'parent_item_colon'          => __( 'Categoría de Portfolio superior:', 'epicpower' ),
		'new_item_name'              => __( 'Nombre de la nueva categoría', 'epicpower' ),
		'add_new_item'               => __( 'Añadir nueva categoría', 'epicpower' ),
		'edit_item'                  => __( 'Editar categoría', 'epicpower' ),
		'update_item'                => __( 'Actualizar categoría', 'epicpower' ),
		'view_item'                  => __( 'Ver categoría', 'epicpower' ),
		'separate_items_with_commas' => __( 'Separar categorías con comas', 'epicpower' ),
		'add_or_remove_items'        => __( 'Añadir o quitar categorías', 'epicpower' ),
		'choose_from_most_used'      => __( 'Elegir de entre las más usadas', 'epicpower' ),
		'popular_items'              => __( 'Categorías populares', 'epicpower' ),
		'search_items'               => __( 'Buscar categorías', 'epicpower' ),
		'not_found'                  => __( 'Not found', 'epicpower' ),
		'no_terms'                   => __( 'No items', 'epicpower' ),
		'items_list'                 => __( 'Items list', 'epicpower' ),
		'items_list_navigation'      => __( 'Items list navigation', 'epicpower' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'show_in_rest'				 => true,
	);
	register_taxonomy( 'portfolio_category', array( 'portfolio_page', 'page' ), $args );

}
// add_action( 'init', 'portfolio_category_custom_taxonomy', 0 );

}

if ( ! function_exists( 'industry_custom_taxonomy' ) ) {

// Register Custom Taxonomy
function industry_custom_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Industries', 'Taxonomy General Name', 'epicpower' ),
		'singular_name'              => _x( 'Industry', 'Taxonomy Singular Name', 'epicpower' ),
		'menu_name'                  => __( 'Industrias', 'epicpower-admin' ),
		'all_items'                  => __( 'Todas las Industria', 'epicpower-admin' ),
		'parent_item'                => __( 'Industria superior', 'epicpower-admin' ),
		'parent_item_colon'          => __( 'Industria superior:', 'epicpower-admin' ),
		'new_item_name'              => __( 'Nombre de la nueva Industria', 'epicpower-admin' ),
		'add_new_item'               => __( 'Añadir nueva Industria', 'epicpower-admin' ),
		'edit_item'                  => __( 'Editar Industria', 'epicpower-admin' ),
		'update_item'                => __( 'Actualizar Industria', 'epicpower-admin' ),
		'view_item'                  => __( 'Ver Industria', 'epicpower-admin' ),
		'separate_items_with_commas' => __( 'Separar Industrias con comas', 'epicpower-admin' ),
		'add_or_remove_items'        => __( 'Añadir o quitar Industrias', 'epicpower-admin' ),
		'choose_from_most_used'      => __( 'Elegir de entre las más usadas', 'epicpower-admin' ),
		'popular_items'              => __( 'Industrias populares', 'epicpower-admin' ),
		'search_items'               => __( 'Buscar Industrias', 'epicpower-admin' ),
		'not_found'                  => __( 'Not found', 'epicpower-admin' ),
		'no_terms'                   => __( 'No items', 'epicpower-admin' ),
		'items_list'                 => __( 'Items list', 'epicpower-admin' ),
		'items_list_navigation'      => __( 'Items list navigation', 'epicpower-admin' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'show_in_rest'				 => true,
	);
	register_taxonomy( 'industry', array( 'portfolio_page', 'product', 'case_study', 'page' ), $args );

}
add_action( 'init', 'industry_custom_taxonomy', 0 );

}

if ( ! function_exists( 'product_category_custom_taxonomy' ) ) {

// Register Custom Taxonomy
function product_category_custom_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Product Categories', 'Taxonomy General Name', 'epicpower' ),
		'singular_name'              => _x( 'Product Category', 'Taxonomy Singular Name', 'epicpower' ),
		'menu_name'                  => __( 'Categorías de Producto', 'epicpower' ),
		'all_items'                  => __( 'Todas las Categorías de Producto', 'epicpower' ),
		'parent_item'                => __( 'Categoría de Producto superior', 'epicpower' ),
		'parent_item_colon'          => __( 'Categoría de Producto superior:', 'epicpower' ),
		'new_item_name'              => __( 'Nombre de la nueva categoría', 'epicpower' ),
		'add_new_item'               => __( 'Añadir nueva categoría', 'epicpower' ),
		'edit_item'                  => __( 'Editar categoría', 'epicpower' ),
		'update_item'                => __( 'Actualizar categoría', 'epicpower' ),
		'view_item'                  => __( 'Ver categoría', 'epicpower' ),
		'separate_items_with_commas' => __( 'Separar categorías con comas', 'epicpower' ),
		'add_or_remove_items'        => __( 'Añadir o quitar categorías', 'epicpower' ),
		'choose_from_most_used'      => __( 'Elegir de entre las más usadas', 'epicpower' ),
		'popular_items'              => __( 'Categorías populares', 'epicpower' ),
		'search_items'               => __( 'Buscar categorías', 'epicpower' ),
		'not_found'                  => __( 'Not found', 'epicpower' ),
		'no_terms'                   => __( 'No items', 'epicpower' ),
		'items_list'                 => __( 'Items list', 'epicpower' ),
		'items_list_navigation'      => __( 'Items list navigation', 'epicpower' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'show_in_rest'				 => true,
		'rewrite'           		 => array( 'slug' => 'product-category' ),
	);
	register_taxonomy( 'product_category', array( 'post', 'sdm_downloads', 'portfolio_page', 'page', 'product', 'case_study' ), $args );

}
add_action( 'init', 'product_category_custom_taxonomy', 0 );

}



function wpb_change_title_text( $title ){
     $screen = get_current_screen();
  
     if  ( 'portfolio_page' == $screen->post_type ) {
          $title = 'Título del proyecto';
     } elseif  ( 'slide' == $screen->post_type ) {
          $title = 'Título de la slide';
     } elseif  ( 'team' == $screen->post_type ) {
          $title = 'Nombre y apellidos';
     }
  
     return $title;
}
add_filter( 'enter_title_here', 'wpb_change_title_text' );

// ADD NEW COLUMN
add_filter('manage_posts_columns', 'epicpower_columns_head');
add_filter('manage_pages_columns', 'epicpower_columns_head');
add_action('manage_posts_custom_column', 'epicpower_columns_content', 10, 2);
add_action('manage_pages_custom_column', 'epicpower_columns_content', 10, 2);
function epicpower_columns_head($defaults) {
	// $defaults = array('featured_image' => 'Imagen') + $defaults;
    $defaults['featured_image'] = 'Imagen';
    $defaults['excerpt'] = 'Resumen';

    return $defaults;
}
 
// SHOW THE FEATURED IMAGE
function epicpower_columns_content($column_name, $post_ID) {
    if ($column_name == 'featured_image') {
    	echo '<div style="height:100px;">' . get_the_post_thumbnail( $post_ID, array(80,80) ) . '</div>';

    }
    if ($column_name == 'excerpt') {
    	$post = get_post($post_ID);
    	echo $post->post_excerpt;
    }
}