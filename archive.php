<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );
$post_type = get_post_type();
$template_post_type = $post_type;

switch ( $post_type ) {
	case 'sdm_downloads':
		$template_post_type = 'background';
		break;
	// case 'case_study':
	// 	$template_post_type = 'product';
	// 	break;
}

// if ('post' == $post_type) $post_type = 'noticia';
$filtrable = false;
if ( is_post_type_archive( 'case_study' ) ) {
	$filtrable = true;
	$taxonomy_filter = 'industry';
}

switch ( $post_type ) {
	case 'job_offer':
		$col_class = 'col-12';
		break;

	case 'case_study':
		$col_class = 'col-md-6 col-lg-4';
		break;

	case 'paper':
		$col_class = 'col-12';
		break;

	default:
		$col_class = 'col-sm-6';
}

?>

<div class="wrapper" id="archive-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

				<header class="page-header">
					<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
					?>
				</header><!-- .page-header -->

				<?php if ( have_posts() ) : ?>

					<?php if ( $filtrable ) {
						echo get_archive_filter( $taxonomy_filter, $post_type );
					} elseif( is_post_type_archive( 'paper' ) ) {
						echo facetwp_display( 'facet', 'search_papers' );
					} ?>

					<?php $col_class .= ' animado mb-4'; ?>

					<div class="filtrable <?php echo $post_type; ?>s">

						<?php /* Start the Loop */ ?>
						<?php while ( have_posts() ) : the_post(); ?>

							<div class="<?php echo $col_class; ?>">

								<?php

								/*
								 * Include the Post-Format-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
								 */
								get_template_part( 'loop-templates/content', $template_post_type );
								?>

							</div>

						<?php endwhile; ?>

					</div>

				<?php else :

					if ( is_post_type_archive( 'job_offer' ) ) :
						get_template_part( 'loop-templates/content-none', 'job-offer' );
					else :
						get_template_part( 'loop-templates/content', 'none' );
					endif;

				endif; ?>

				<?php if ( is_post_type_archive( 'job_offer' ) ) {

					if ( is_active_sidebar( 'job-offers-content' ) ) {
						echo '<div class="p-4 p-md-5 mb-5 border border-light">';
							dynamic_sidebar( 'job-offers-content' );
						echo '</div>';
					}

				} ?>

			</main><!-- #main -->

			<!-- The pagination component -->
			<?php understrap_pagination(); ?>

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

		</div> <!-- .row -->

	</div><!-- #content -->

	</div><!-- #archive-wrapper -->

<?php get_footer(); ?>
