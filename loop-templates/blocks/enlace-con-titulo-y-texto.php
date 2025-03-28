<?php
// Create id attribute allowing for custom "anchor" value.
$id = 'enlace-foto-y-texto-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'enlace-foto-y-texto';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

$titulo = get_field('enlace_titulo');
$texto = get_field('enlace_texto');
$enlace_externo = get_field('enlace_externo');
$texto_boton = get_field('enlace_texto_boton');
$target = '';
$link = false;

if($enlace_externo) {
	$link = $enlace_externo;
	$target = '_blank';
} else {
	$link = get_field('enlace_interno');
}

if(!$texto_boton) $texto_boton = __( 'Continue reading', 'understrap' );

$r = '<div class="mb-4 animado">';

	if ($titulo) $r .= '<h3 class="related-content-title">'.$titulo.'</h3>';

	if($texto) $r .= $texto;
	if($texto_boton) $r .= '<p><a class="read-more" href="'.$link.'" target="'.$target.'">'.$texto_boton.'</a></p>';

$r .= '</div>';

echo $r;
?>