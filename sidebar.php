			
		<?php if ( is_home() || is_single() || is_page() || is_404() ) : ?>

			<aside class="widget-area col-xs-3 col-md-3 col-lg-3" aria-label="<?php esc_attr_e( 'aside', 'HJYL_HILAU' ); ?>">
				<?php if ( is_home() && is_active_sidebar( 'home' ) ) { ?>
				<?php dynamic_sidebar( 'home' ); ?>
				<?php }elseif(is_single() && is_active_sidebar( 'single' )){ ?>
				<?php dynamic_sidebar( 'single' ); ?>
				<?php }elseif(is_page() && is_active_sidebar( 'page' )){ ?>
				<?php dynamic_sidebar( 'page' ); ?>
				<?php }elseif(is_404() && is_active_sidebar( 'error' )){ ?>
				<?php dynamic_sidebar( 'error' ); ?>
				<?php } ?>
			</aside><!-- .widget-area -->

		<?php else: ?>
			<?php if ( is_active_sidebar( 'other' )) { ?>
			<aside class="widget-area col-xs-3 col-md-3 col-lg-3" aria-label="<?php esc_attr_e( 'aside', 'HJYL_HILAU' ); ?>">
				<?php dynamic_sidebar( 'other' ); ?>
			</aside><!-- .widget-area-other -->
			<?php } ?>
		
		<?php endif; ?>