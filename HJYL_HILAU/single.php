<?php get_header(); ?>
		
<?php get_template_part( 'inc/content', 'slide'); ?>

		<section id="primary" class="content-area row">
			<main id="main" class="site-main col-xs-12 <?php if( is_active_sidebar( 'single' )) { ?> col-md-9 col-lg-9 <?php }else{ ?> col-md-12 col-lg-12<?php } ?>">
			<?php
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
				get_template_part( 'inc/content');
				
			echo '<div class="clearfix"></div><nav id="nav-single"><p class="float-md-left">';
			previous_post_link( '%link', __( 'Previous: %title', 'HJYL_HILAU' ) );
			echo '</p><p class="float-md-right">';
			next_post_link( '%link', __( 'Next: %title', 'HJYL_HILAU' ) );
			echo '</p></nav><!-- #nav-single -->';
				
				comments_template( '', true );
			}

			} else {
				get_template_part( 'inc/content', 'none');
			}
			?>
			</main><!-- .site-main -->



<?php get_sidebar(); ?>
		
		</section><!-- .content-area -->
		
<?php get_footer(); ?>