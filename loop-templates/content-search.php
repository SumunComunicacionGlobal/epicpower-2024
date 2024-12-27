<?php
/**
 * Search results partial template.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
$pt = get_post_type();
$pto = get_post_type_object( $pt );
$pt_name = $pto->labels->singular_name;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php
		the_title(
			sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark"><span>', esc_url( get_permalink() ) ),
			'</span><span class="post-type-name">'.$pt_name.'</span></a></h2>'
		);
		?>

	</header><!-- .entry-header -->

</article><!-- #post-## -->
