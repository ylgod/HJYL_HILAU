<?php $options = get_theme_mod( 'hjyl_hilau_options'); ?>
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
						printf( '<span class="sticky-post"><i class="fas fa-thumbtack"></i> %s</span>', __( 'Featured', 'HJYL_HILAU' ) );
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
							if(!empty($options['single_google_ad'])){
							echo '<figure class="single_google_ad">';
								echo $options['single_google_ad'];
							echo '</figure>';
							}
							the_content();
							wp_link_pages( array( 'before' => '<nav class="page-link"><i class="fa fa-folder-open" aria-hidden="true"></i> <span>' . __( 'Pages:', 'HJYL_HILAU' ) . '</span>', 'after' => '</nav>' ) );
						}else{
							echo wp_trim_words( get_the_content(), 200, '......<a href="'. get_permalink() .'">'.__( 'Continue reading', 'HJYL_HILAU' ).'</a>'  );
						}
					?>
				</div><!-- .entry-content -->

				<footer class="entry-footer">
				<?php
					if(is_singular() && !empty($options['singlar_google_ad'])){
					echo '<figure class="singlar_google_ad mx-auto">';
					echo $options['singlar_google_ad'];
					echo '</figure>';
					}
				?>
				<?php if(!is_singular()){ ?>
					<span class="fas fa-user author">
						<?php the_author_posts_link(); ?>
					</span>
					<span class="fas fa-flag cat-links" >
						<?php the_category(', '); ?>
					</span>
					<span class="fas fa-clock last-updated" title="<?php printf(__('%s', 'HJYL_HILAU'),the_time('Y-m-d G:i:s')); ?>">
						<?php printf(__('%s', 'HJYL_HILAU'),timeago(get_gmt_from_date(get_the_time('Y-m-d G:i:s')))); ?>
					</span>
					<?php comments_popup_link( __( ' Leave a reply', 'HJYL_HILAU' ), __( ' 1 Comment ', 'HJYL_HILAU' ), __( ' % Comments', 'HJYL_HILAU' ),'fas fa-comments comments-views',__( ' Comments Off', 'HJYL_HILAU' ) ); ?>
					<?php edit_post_link( __( 'Edit', 'HJYL_HILAU' ), '<span class="fa fa-pencil-square-o edit-link"> ', '</span>' ); ?>
				<?php } ?>
				</footer><!-- .entry-footer -->
			</article><!-- #post-<?php the_ID(); ?> -->