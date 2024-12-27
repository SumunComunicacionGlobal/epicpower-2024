<?php
// Create id attribute allowing for custom "anchor" value.
$id = 'link-read-more-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'link-read-more';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

$link = get_field('enlace');

$titulo = __( 'Texto del enlace', 'epicpower-admin' );
$url = false;
$target = '';

if ($link) {
	if ( isset($link['title']) ) $titulo = $link['title'];
	if ( isset($link['url']) ) $url = $link['url'];
	if ( isset($link['target']) ) $target = $link['target'];
}

echo '<a class="read-more" href="'.$url.'" title="'.$titulo.'" target="'.$target.'">'.$titulo.'</a>';

?>