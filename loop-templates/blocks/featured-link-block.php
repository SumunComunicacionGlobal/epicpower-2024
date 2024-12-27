<?php
// Create id attribute allowing for custom "anchor" value.
$id = 'featured-link-block-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'featured-link-block rounded';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

$args = array(
	'post_type'			=> 'product',
	'posts_per_page'	=> -1,
);

$titulo = get_field('titulo');
$contenido = get_field('contenido');
$enlace = get_field('enlace_interno');
$anchor = get_field('anchor');
$texto_enlace = get_field('texto_enlace');
if (!$texto_enlace) {
	$texto_enlace = __( 'Read more', 'epicpower' );
}
if ($anchor) $enlace .= '#' . $anchor;

?>

<?php if ($enlace) { ?>
	<a href="<?php echo esc_attr($enlace); ?>" class="<?php echo esc_attr($className); ?> bg-primary py-5 px-4">
<?php } else { ?>
	<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> bg-primary py-5 px-4">
<?php } ?>

	<div class="featured-link-block-inner">

		<h3 class="has-white-color"><?php echo esc_attr($titulo); ?></h3>
		<div class="content has-white-color"><?php echo wpautop( $contenido ); ?></div>
		<?php if ($enlace) { ?>
			<span class="read-more has-white-color"><?php echo $texto_enlace; ?></span>
		<?php } ?>
	</div>

<?php if ($enlace) { ?>
	</a>
<?php } else { ?>
	</div>
<?php } ?>
