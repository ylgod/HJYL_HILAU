<?php get_header(); ?>
<?php
	if(is_home() && !is_paged() && of_get_option('is_blog') != 1){ 
?>		
<?php get_template_part( 'inc/content', 'slide'); ?>
<?php }else{ ?>
		<section id="primary" class="content-area row">
			<main id="main" class="site-main col-xs-12 <?php if( is_active_sidebar( 'home' )) { ?> col-md-9 col-lg-9 <?php }else{ ?> col-md-12 col-lg-12<?php } ?>">
			<?php
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
				get_template_part( 'inc/content');
			}
				// Previous/next page navigation.
				the_posts_pagination( array(
				'prev_text'          => __('<<', 'HJYL_HILAU'),
				'next_text'          => __('>>', 'HJYL_HILAU'),
				) );
			} else {
				get_template_part( 'inc/content', 'none');
			}
			?>
			</main><!-- .site-main -->



<?php get_sidebar(); ?>
		
		</section><!-- .content-area -->
<?php } ?>	
<?php get_footer(); ?>