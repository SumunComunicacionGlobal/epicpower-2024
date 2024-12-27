<?php
// Create id attribute allowing for custom "anchor" value.
$id = 'related-content-title-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'related-content-title';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

$titulo = get_field('titulo');

echo '<h3 class="related-content-title">'.$titulo.'</h3>';

?>