<?php
/**
 * Single post partial template.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
$post_type = get_post_type();
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<?php 
	if ( in_array( $post_type, array( 'post' ) ) ) {
		echo get_the_post_thumbnail( $post->ID, 'large', array('class' => 'imagen-destacada ' . ANIMATION_CLASS ) ); 
	} 
	?>

	<header class="entry-header">

		<?php if('post' == $post_type ) { ?>

			<div class="entry-meta">

				<?php understrap_posted_on(); ?>

			</div><!-- .entry-meta -->

		<?php } ?>

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		
	</header><!-- .entry-header -->

	<div class="entry-content">
		
		<?php 

		$datasheet_downloads  = (isset($post_meta['datasheet_downloads'])) ? $post_meta['datasheet_downloads'][0] : false;
		$datasheet_downloads = get_post_meta( get_the_ID(), 'datasheet_downloads', true );
		if ($datasheet_downloads) {
			echo '<p class="lead"><a href="'.get_the_permalink( $datasheet_downloads[0] ).'" title="'.__( 'Download datasheet', 'epicpower' ).'" class="read-more" target="_blank" rel="noopener noreferrer"><i class="fa fa-download"></i> '.get_the_title( $datasheet_downloads[0] ).'</a></p>';
		}
		?>


		<?php the_content(); ?>

		<?php
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
				'after'  => '</div>',
			)
		);
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
