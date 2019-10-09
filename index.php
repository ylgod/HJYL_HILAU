<?php get_header(); ?>
<?php if(is_home()&&!is_paged()){ ?>		
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
				echo '<nav class="hjylNav" aria-label="Page navigation">';
					par_pagenavi(4);
				echo '</nav>';
			} else {
				get_template_part( 'inc/content', 'none');
			}
			?>
			</main><!-- .site-main -->



<?php get_sidebar(); ?>
		
		</section><!-- .content-area -->
		
<?php get_footer(); ?>