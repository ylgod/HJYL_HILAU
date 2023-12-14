			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<figure>
					<?php
					if(!is_singular()){
					if( has_post_thumbnail()){    //如果有缩略图，则显示缩略图
						the_post_thumbnail('post');
					} else {
						post_thumbnail(790,300);
					}	?>
					</figure>
					<?php
					if ( is_sticky() && is_home() && ! is_paged() ) {
						printf( '<span class="sticky-post">%1$s %2$s</span>', hjyl_get_svg( array( 'icon' => 'thumb-tack') ) , __( 'Featured', 'HJYL_HILAU' ) );
					}
					if ( is_singular() ) :
						the_title( '<h1 class="entry-title">', '</h1>' );
					else :
						the_title( sprintf( '<h2 class="entry-title"><a href="%1$s" title="%2$s" rel="bookmark">', esc_url( get_permalink()), esc_html(get_the_title()) ), '</a></h2>' );
					endif;
					}
					?>
				</header><!-- .entry-header -->

				<?php //hjyl_post_thumbnail(); ?>

				<div class="entry-content">
					<?php
						if(is_singular()){
							if(!empty(of_get_option('single_google_ad'))){
							echo '<figure class="single_google_ad">';
								echo of_get_option('single_google_ad');
							echo '</figure>';
							}
							the_content();
							wp_link_pages( array( 'before' => '<nav class="page-link">'.hjyl_get_svg( array( 'icon' => 'folder-open') ).'<span>' . __( 'Pages:', 'HJYL_HILAU' ) . '</span>', 'after' => '</nav>' ) );
						}else{
							echo wp_trim_words( get_the_content(), 200, '......<a href="'. get_permalink() .'">'.__( 'Continue reading', 'HJYL_HILAU' ).'</a>'  );
						}
					?>
				</div><!-- .entry-content -->

				<footer class="entry-footer">
				<?php
					if(is_singular() && !empty(of_get_option('singlar_google_ad'))){
					echo '<figure class="singlar_google_ad mx-auto">';
					echo of_get_option('singlar_google_ad');
					echo '</figure>';
					}
				?>
				<?php if(!is_singular()){ ?>
					<span class="author">
						<?php echo hjyl_get_svg( array( 'icon' => 'user' ) ); ?>
						<?php the_author_posts_link(); ?>
					</span>
					<span class="cat-links" >
						<?php echo hjyl_get_svg( array( 'icon' => 'bars' ) ); ?>
						<?php the_category(', '); ?>
					</span>
					<span class="last-updated" title="<?php printf(__('%s', 'HJYL_HILAU'),the_time('Y-m-d G:i:s')); ?>">
						<?php echo hjyl_get_svg( array( 'icon' => 'time' ) ); ?>
						<?php printf(__('%s', 'HJYL_HILAU'),timeago(get_gmt_from_date(get_the_time('Y-m-d G:i:s')))); ?>
					</span>
					<span>
						<?php echo hjyl_get_svg( array( 'icon' => 'comment' ) ); ?>
						<?php comments_popup_link( __( 'Leave a reply', 'HJYL_HILAU' ), __( '1 Comment', 'HJYL_HILAU' ), __( '% Comments', 'HJYL_HILAU' ),'comments-views',__( 'Comments Off', 'HJYL_HILAU' ) ); ?>
					</span>
					<?php edit_post_link( __( 'Edit', 'HJYL_HILAU' ), '<span class="edit-link">'.hjyl_get_svg( array( 'icon' => 'edit' ) ).'', '</span>' ); ?>
					
				<?php } ?>
				<?php if(is_singular()){ ?>
				<div class="reward">
					<div class="reward-button">
					  <?php _e('$', 'HJYL_HILAU'); ?>
					  <span class="reward-code"><span class="alipay-code"><img class="alipay-img" src="<?php if(!empty(of_get_option('alipay'))) { echo of_get_option('alipay'); } ?>"><b><?php _e('Alipay Donate', 'HJYL_HILAU'); ?></b></span><span class="wechat-code"><img class="wechat-img" src="<?php if(!empty(of_get_option('wxpay'))) { echo of_get_option('wxpay'); } ?>"><b><?php _e('WeChat Pay Donate', 'HJYL_HILAU'); ?></b></span></span>
					</div>
					<p class="reward-notice"><?php _e('If valuable for you, welcome to donate.', 'HJYL_HILAU'); ?></p>
				 
				</div>
				<?php } ?>
				</footer><!-- .entry-footer -->
			</article><!-- #post-<?php the_ID(); ?> -->