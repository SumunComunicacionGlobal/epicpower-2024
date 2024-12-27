<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( is_category() ) {
	$terms = get_categories( array( 'parent' => get_queried_object_id() ) );
} else {
	$terms = get_categories();
}
$page_for_posts_id = get_option( 'page_for_posts' );
$ver_todo_active_class = ( is_home() ) ? 'active' : '';
$queried_obj = get_queried_object();
$queried_obj_id = $queried_obj->term_id;

if ( $terms ) { ?>

	<nav class="filter-navbar navbar navbar-expand-lg justify-content-center navbar-light mb-2">

		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#filter-navbar-collapse" aria-controls="filter-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-label me-1"><?php echo __( 'Por temas', 'smn' ); ?></span> <span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="filter-navbar-collapse">

			<div class="nav navbar-nav mx-auto">

				<?php if ( $page_for_posts_id ) { ?>

					<a class="nav-item nav-link <?php echo $ver_todo_active_class; ?>" href="<?php echo esc_url( get_the_permalink( $page_for_posts_id ) ); ?>"><?php echo __( 'All' ); ?></a>

				<?php } ?>

				<?php foreach ( $terms as $term ) { 
					$active_class = ( $queried_obj_id == $term->term_id ) ? 'active' : '';
					?>

					<a class="nav-item nav-link <?php echo $active_class; ?>" href="<?php echo esc_url( get_term_link($term) ); ?>"><?php echo $term->name; ?></a>

				<?php } ?>

			</div>

		</div>

	</nav>

<?php }