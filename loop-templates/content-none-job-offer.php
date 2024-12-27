<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<div class="p-4 bg-light mb-4 no-job-offers">
	<p class="mb-0"><?php esc_html_e( 'There are no active job offers at the moment. You can fill out the spontaneous application form below if you wish.', 'understrap' ); ?></p>
</div>