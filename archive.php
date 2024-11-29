<?php get_header(); $options = get_theme_mod( 'hjyl_hilau_options'); ?>

		<section id="primary" class="content-area row">
				<?php
					if(!empty($options['archive_google_ad'])){
					echo '<figure class="archive_google_ad mx-auto">';
					echo $options['archive_google_ad'];
					echo '</figure>';
					}
				?>
			<main id="main" class="site-main col-xs-12 <?php if(is_active_sidebar( 'other' )) { ?> col-md-9 col-lg-9 <?php }else{ ?> col-md-12 col-lg-12<?php } ?>">
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