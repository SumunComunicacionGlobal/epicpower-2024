<?php

$id = get_the_ID();

if(get_post_meta($id, "qode_page_background_color", true) != ""){
	$background_color = get_post_meta($id, "qode_page_background_color", true);
}else{
	$background_color = "";
}

$content_style_spacing = "";
if(get_post_meta($id, "qode_margin_after_title", true) != ""){
	if(get_post_meta($id, "qode_margin_after_title_mobile", true) == 'yes'){
		$content_style_spacing = "padding-top:".esc_attr(get_post_meta($id, "qode_margin_after_title", true))."px !important";
	}else{
		$content_style_spacing = "padding-top:".esc_attr(get_post_meta($id, "qode_margin_after_title", true))."px";
	}
}

$single_class = array('blog_single', 'blog_holder');
?>
<?php get_header(); ?>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
	<?php if(get_post_meta($id, "qode_page_scroll_amount_for_sticky", true)) { ?>
		<script>
		var page_scroll_amount_for_sticky = <?php echo get_post_meta($id, "qode_page_scroll_amount_for_sticky", true); ?>;
		</script>
	<?php } ?>
					<div class="container"<?php if($background_color != "") { echo " style='background-color:". $background_color ."'";} ?>>
								<div class="container_inner default_template_holder" <?php qode_inline_style($content_style_spacing); ?>>


							<div class="two_columns_66_33 background_color_sidebar grid2 clearfix">
							<div class="column1">
					
									<div class="column_inner">
										<div <?php qode_class_attribute(implode(' ', $single_class)) ?>>
											<?php
											get_template_part('templates/descarga');
											?>
										</div>
										
										<?php echo "<br/><br/>"; ?> 
									</div>
								</div>	
								<div class="column2">
									<?php get_sidebar(); ?>
								</div>
							</div>
					</div>
                 </div>
<?php endwhile; ?>
<?php endif; ?>	


<?php get_footer(); ?>	