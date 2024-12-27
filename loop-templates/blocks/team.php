<?php
// Create id attribute allowing for custom "anchor" value.
$id = 'team-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'team';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

$post_type = 'team';
$args = array(
	'post_type'			=> $post_type,
	'posts_per_page'	=> -1,
);

// Load values and assign defaults.
$mostrar_miembros = get_field('mostrar_miembros') ?: 'todos';
if ('seleccionar' == $mostrar_miembros ) {
	$seleccionados = get_field('miembros');
	$args['post__in'] = $seleccionados;
}

$q = new WP_Query($args);

if ($q->have_posts()) {

	echo '<div class="row">';

		while ($q->have_posts()) { $q->the_post();

			echo '<div class="col-sm-6 col-md-4 col-lg-3 animado">';
			
				get_template_part( 'loop-templates/content', $post_type );

			echo '</div>';
		}

	echo '</div>';

}
?>