<?php
// Create id attribute allowing for custom "anchor" value.
$id = 'pages-carousel-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'wp-block-pages-carousel';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

$args = array(
	'post_type' => 'page',
	'posts_per_page' => -1,
);

// Load values and assign defaults.
$parent_id = get_field( 'parent_id' );
$post_ids = get_field('post_ids');

if ($parent_id) {
	$args['post_parent'] = $parent_id;
} elseif ($post_ids) {
	$args['post__in'] = $post_ids;
	$args['orderby'] = 'post__in';
} else {
	return false;
}

$show_excerpt = get_field('show_excerpt');
$show_image = get_field('show_image');
$color_scheme = get_field('color_scheme');

$q = new WP_Query($args);

if ($q->have_posts()) {

	echo '<div id="'.$id .'" class="'. $className .'">';

		echo '<div class="slick-carousel">';

			while ($q->have_posts()) { $q->the_post();

				echo '<div class="pages-carousel-item">';
				
					get_template_part( 'loop-templates/content', 'pages-carousel-item', array(
						'show_excerpt' => $show_excerpt,
						'show_image' => $show_image,
						'color_scheme' => $color_scheme,
					) );

				echo '</div>';
			}

		echo '</div>';

	echo '</div>';

}

wp_reset_postdata();
?>