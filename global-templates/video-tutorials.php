<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$args = array(
    'post_type' => 'video_tutorial',
    'posts_per_page' => -1
);

$query = new WP_Query($args);

if ($query->have_posts()) {

    echo '<div class="row">';

        while ($query->have_posts()) {
            $query->the_post();

            echo '<div class="col-md-6 col-lg-4">';

            $blocks = parse_blocks(get_the_content());

            foreach ($blocks as $block) {

                if ($block['blockName'] === 'core/embed' || $block['blockName'] === 'core/video') {
                    echo '<div class="video-wrapper mb-2">';
                        echo apply_filters( 'the_content', $block['innerHTML'] );
                    echo '</div>';
                    break;
                }
                
            }

            the_title('<h5 class="card-title">', '</h5>');
            the_excerpt();

            echo '</div>';

        }

    echo '</div>';

    wp_reset_postdata();

} else {

    echo '<p class="text-muted">' . __( 'No video tutorials found', 'epicpower' ) . '</p>';

}