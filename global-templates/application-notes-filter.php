<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

echo do_shortcode( '[facetwp facet="product_categories"]' );

return false;

$post_type = 'sdm_downloads';

$product_categories = get_application_notes_product_categories( 'product_category', $post_type );

// Check if there are any product categories
if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) {
	echo '<form action="" method="get" class="form-inline">';
		echo '<div class="form-group">';
		echo '<label for="product_category">' . esc_html__( 'Category', 'epicpower' ) . '</label>';
			echo '<select name="product_category" id="product_category" class="form-select" onchange="redirectToCategory(this)">';
				echo '<option value="">' . esc_html__( 'Select a category', 'epicpower' ) . '</option>';

				// Loop through each product category and create an option element
				foreach ( $product_categories as $category ) {
					echo '<option value="' . esc_attr( $category->slug ) . '">' . esc_html( $category->name ) . '</option>';
				}

			echo '</select>';
		echo '</div>';
	echo '</form>';
	?>
	<script type="text/javascript">
		function redirectToCategory(select) {
			var categorySlug = select.value;
			if (categorySlug) {
				window.open('<?php echo esc_url( get_term_link( APPLICATION_NOTES_TERM_ID ) ); ?>?product_category=' + categorySlug, '_blank');
			}
		}
	</script>
	<?php
}