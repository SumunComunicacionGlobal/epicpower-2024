<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
global $post;
$post_meta = get_post_meta( get_the_ID() );
$subtitulo = (isset($post_meta['subtitulo'])) ? $post_meta['subtitulo'][0] : false;
$datos_tecnicos = (isset($post_meta['datos_tecnicos'])) ? $post_meta['datos_tecnicos'][0] : false;
$datos_tecnicos_html = get_datos_tecnicos_html( $datos_tecnicos );
$datasheet_pdf = (isset($post_meta['datasheet_pdf'])) ? $post_meta['datasheet_pdf'][0] : false;
$datasheet_downloads  = (isset($post_meta['datasheet_downloads'])) ? $post_meta['datasheet_downloads'][0] : false;

$datasheet_downloads = get_field('datasheet_downloads', $post);
// $datasheet_pdf_url = false;
// if($datasheet_downloads) {
// 	$datasheet_pdf_url = get_post_meta( $datasheet_downloads[0]->ID, 'sdm_upload', true );
// }

$link_before = '';
$link_after = '';

$enlace_a_descargas = false;
if( isset( $args['enlace_a_descargas']) ) {
	$enlace_a_descargas = $args['enlace_a_descargas'];
}

if( !$enlace_a_descargas ) {
	$link_before = '<a href="'.get_the_permalink().'" title="'.get_the_title().'">';
	$link_after = '</a>';
}

?>

<article <?php post_class('mb-5 bg-light product-card'); ?> id="post-<?php the_ID(); ?>">

		<div class="row no-gutters">

			<?php if( has_post_thumbnail() ) : ?>

				<div class="col-md-4 product-image-column">

					<div class="product-image-column-inner">
						
						<?php echo $link_before; ?>

							<?php echo get_the_post_thumbnail( $post->ID, 'large', array('class' => '') ); ?>

						<?php echo $link_after; ?>

					</div>

				</div>

			<?php endif; ?>

			<div class="col mb-3 product-content-column">

				<div class="product-content-column-inner">

					<?php
					echo '<p class="h5 entry-title">';
						echo $link_before;
							the_title();
						echo $link_after;
					echo '</p>';

					if ($subtitulo) echo '<div class="entry-subtitle">'.$subtitulo.'</div>';
					if ($post->post_excerpt) echo '<div class="small">' . wpautop( $post->post_excerpt ) . '</div>';
					if ($datos_tecnicos) echo $datos_tecnicos_html;
					
					echo '<div class="footer-links">';

						// if ($datasheet_pdf) {
						// 	echo '<a href="'.wp_get_attachment_url( $datasheet_pdf ).'" title="'.__( 'Download datasheet', 'epicpower' ).'" class="read-more" target="_blank" rel="noopener noreferrer">'.__( 'Datasheet', 'epicpower' ).'</a>';
						if( $enlace_a_descargas ) {

							if ($datasheet_downloads) {
								echo '<a href="'.get_the_permalink( $datasheet_downloads[0] ).'" title="'.__( 'Download datasheet', 'epicpower' ).'" class="read-more" target="_blank" rel="noopener noreferrer">'.__( 'Datasheet', 'epicpower' ).'</a>';
							}

							$link = add_query_arg( array(
								'product_cat_filter'		=> implode(',', wp_get_post_terms( get_the_ID(), 'product_category', array( 'fields' => 'slugs') ))
							), get_the_permalink( DOWNLOADS_ID ) );

							echo '<a href="'. $link .'" title="'. get_the_title( DOWNLOADS_ID ).'" target="_blank" rel="noopener noreferrer"><i class="fa fa-download"></i> '. get_the_title( DOWNLOADS_ID ) .'</a>';
						} else {
							if ($datasheet_downloads) {
								echo '<a href="'.get_the_permalink( $datasheet_downloads[0] ).'" title="'.__( 'Download datasheet', 'epicpower' ).'" class="read-more" target="_blank" rel="noopener noreferrer">'.__( 'Datasheet', 'epicpower' ).'</a>';
							} else {
								echo '<a href="'.get_the_permalink().'" title="'.get_the_title().'" class="read-more">'.__( 'Details', 'epicpower' ).'</a>';
							}

							echo '<a href="'. get_the_permalink() .'#downloads" title="'. get_the_title().': '. __( 'Downloads', 'epicpower' ) .'"><i class="fa fa-download"></i> '. __( 'Downloads', 'epicpower' ) .'</a>';
						}
					?>

					</div>

					<?php edit_post_link( null, '', '', $post->ID, 'btn btn-primary btn-sm' ); ?>

				</div>

			</div>

		</div>

</article><!-- #post-## -->
