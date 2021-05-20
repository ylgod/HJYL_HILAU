<?php get_header(); $options = get_theme_mod('hjyl_hilau_options'); ?>
<?php
	$is_blog = isset($options['is_blog'] ) ? $options['is_blog'] : 0;
	if(is_home() && !is_paged() && $is_blog == 0){ ?>		
<?php get_template_part( 'inc/content', 'slide'); ?>
<?php } ?>
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
		
<?php get_footer(); ?>