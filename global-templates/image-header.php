<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


if ( smn_has_alignfull_first() ) {
	return;
}

if ( is_page() ) {
	$hide_header_content = get_post_meta( get_the_ID(), 'hide_header_content', true );
	if ( $hide_header_content ) {
		smn_breadcrumb();
		return;
	}
} else {
	smn_breadcrumb();

}

?>



<?php if ( is_page() && !is_front_page() ) { ?>

	<?php
	// $url_video_cabecera = get_post_meta( get_the_ID(), 'url_video_cabecera', true );
	$contenido_cabecera = get_post_meta( get_the_ID(), 'contenido_cabecera', true );
	if ( !$contenido_cabecera ) {
		smn_breadcrumb();
		return false;
	}
	$class_cabecera = '';

	$html_cabecera = '';
	$style_cabecera = '';

	if (is_singular('page') && '' != $post->post_excerpt) {
		$contenido_cabecera .= '<div class="has-medium-font-size has-white-color">' . wpautop( $post->post_excerpt ) . '</div>';
	}

	if ($contenido_cabecera) {
		$class_cabecera .= ' has-content';
		$contenido_cabecera = wpautop( $contenido_cabecera );
	}

	if (is_singular('page') && has_post_thumbnail( get_the_ID() )) {
		$class_cabecera .= ' has-bg';
		$bg_size_cabecera = get_post_meta( get_the_ID(), 'tamano_fondo_cabecera', true );
		if (!$bg_size_cabecera) $bg_size_cabecera = 'cover';
		$style_cabecera .= 'style="background-image:url('.get_the_post_thumbnail_url( get_the_ID(), 'large' ).'); background-size: '.$bg_size_cabecera.';"';
	}
	if($contenido_cabecera) {
		
		$html_cabecera .= '<div class="container '.ANIMATION_CLASS.'">';
			$html_cabecera .= '<div class="row">';
				$html_cabecera .= '<div class="col-md-6 contenido-cabecera">';
					$html_cabecera .= $contenido_cabecera;
					// $html_cabecera .= paginas_hijas( array('imagenes' => 'no') );
					// $html_cabecera .= do_shortcode( '[paginas_hijas imagenes="no"]' );
					$html_cabecera .= paginas_hijas_cabecera();
				$html_cabecera .= '</div>';
			$html_cabecera .= '</div>';
			$html_cabecera .= '<a class="scroll-button" href="#content" title="'.__( 'Scroll to content', 'epicpower' ).'"></a>';
		$html_cabecera .= '</div>';
	}
	?>

	<div class="cabecera bg-cover text-dark <?php echo $class_cabecera; ?>" <?php echo $style_cabecera; ?>>
			
		<?php video_background(); ?>

		<?php echo $html_cabecera; ?>

	</div>

		<?php // if($contenido_cabecera) echo '<div class="scroll-button-wrapper"><div class="container"><a class="scroll-button" href="#content" title="'.__( 'Scroll to content', 'epicpower' ).'"></a></div></div>'; ?>

<?php } ?>

<?php
// smn_breadcrumb();

/*******/
return false;

$image_id = false;
$title = '';
$description = '';

if ( is_singular() ) {
	$image_id = get_post_thumbnail_id( get_the_ID() );
	$title = get_the_title();
} elseif ( is_archive() ) {
	$image_id = get_term_meta( get_queried_object_id(), 'thumbnail_id', true );
	$title = get_the_archive_title();
	$description = get_the_archive_description();
}
?>

<header class="wp-block-cover alignfull is-style-image-header">

	<span aria-hidden="true" class="wp-block-cover__background has-background-dim"></span>

	<?php if ( $image_id ) echo wp_get_attachment_image( $image_id, 'large', false, array('class' => 'wp-block-cover__image-background') ); ?>

	<div class="wp-block-cover__inner-container container">

		<?php if ( is_singular( 'post' ) ) { ?>

			<div class="entry-meta text-white">

				<?php understrap_posted_on(); ?>

			</div><!-- .entry-meta -->

		<?php } ?>

		<h1 class="entry-title"><?php echo $title; ?></h1>

		<?php if ( $description) { ?>
			
			<div class="lead"><?php echo $description; ?></div>
		
		<?php } ?>

	</div>

</header>

<?php smn_breadcrumb(); ?>

