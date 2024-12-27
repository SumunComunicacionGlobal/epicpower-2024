<?php
// Create id attribute allowing for custom "anchor" value.
$id = 'enlaces-paginas-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'enlaces-paginas';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

$opcion = get_field('enlaces_paginas');
$columnas = get_field('enlaces_paginas_columnas');


switch ($opcion) {
	case 'hijas_por_id':
		$parent_id = get_field('enlaces_paginas_parent_id');
		echo paginas_hijas( array(
			'post_parent' => $parent_id,
			'columnas' => $columnas,
		));
		break;
	
	case 'por_id':
		$page_ids = get_field('enlaces_paginas_ids');
		$page_ids = implode(',', $page_ids);
		echo paginas_hijas( array(
			'ids' => $page_ids,
			'columnas' => $columnas,
		));
		break;
	
	default:
		echo paginas_hijas( array(
			'columnas' => $columnas,
		));
		break;
}

?>