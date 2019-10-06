			<?php $options = get_theme_mod( 'hjyl_hilau_options'); if(is_home()) {?>
			<div class="col-ul row" id="colRow">
				<div class="col-xs-12 col-md-8 colnum-1">
				<!--------------幻灯片  开始--------------->
				  <div class="slider11">
					<div id="coin-slider" class="carousel slide" data-ride="carousel">
						<div id="nav_wrapper" class="carousel-inner">
						<?php
							$options['slide'] = isset($options['slide']) ? $options['slide'] : '';
							$args = array( 'post_type' => 'post','ignore_sticky_posts' => 1 , 'category__in' => $options['slide'], 'posts_per_page' => 5);
							$news_query = new WP_Query($args);	
							while($news_query->have_posts() ) : $news_query->the_post();
						?>
						<a class="carousel-item" href="<?php the_permalink() ?>" target="_blank">
						<?php
							if(has_post_thumbnail()){    //如果有缩略图，则显示缩略图
								the_post_thumbnail('slide');
							} else {
								post_thumbnail(700,380);
							}
						?>
						<h3 class="carousel-caption"><?php the_title(); ?></h3>
						</a>
						<?php wp_reset_postdata(); endwhile; ?> 
						</div>
						<!-- 左右切换按钮 -->
						<a class="carousel-control-prev" href="#coin-slider" data-slide="prev">
							<span class="carousel-control-prev-icon"></span>
						</a>
						<a class="carousel-control-next" href="#coin-slider" data-slide="next">
							<span class="carousel-control-next-icon"></span>
						</a>
					</div>
				  </div>
				  <!--------------幻灯片  结束--------------->
				</div>
				<div class="col-xs-12 col-md-4 colnum-2">
					<span><i class="fas fa-list"></i> <?php _e('Lasted Posts', 'HJYL_HILAU'); ?></span>
					<ul class="list-unstyled">
						<?php query_posts('posts_per_page=13&ignore_sticky_posts=1'); while (have_posts()) : the_post(); ?>
						<li>
							<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute( array( 'before' => '', 'after' => '' ) ); ?>">
							<?php if("" == get_the_title()) {
								printf(__('Untitled #%s', 'HJYL_HILAU'),get_the_date('Y-m-d'));
							}else{
								echo wp_trim_words(get_the_title(), 18); 
							}?>
							</a><span class="list_date"><?php echo timeago(get_gmt_from_date(get_the_time('Y-m-d G:i:s'))); ?></span>
						</li>
						<?php endwhile; wp_reset_query(); ?>
					</ul>
				</div>
				<div class="col-xs-12 col-md-4 colnum-3">
					<span><i class="fas fa-list"></i> <?php _e('Lasted Comments', 'HJYL_HILAU'); ?></span>
					<ul class="list-unstyled">	
						<?php new_comment_posts(); ?>
					</ul>
				</div>
				<div class="col-xs-12 col-md-4 colnum-4">
					<span><i class="fas fa-list"></i> <?php _e('Lasted Modified', 'HJYL_HILAU'); ?></span>
					<ul class="list-unstyled">	
						<?php query_posts('posts_per_page=10&ignore_sticky_posts=1&orderby=modified'); while (have_posts()) : the_post(); ?>
						<li>
							<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute( array( 'before' => '', 'after' => '' ) ); ?>">
							<?php if("" == get_the_title()) {
								printf(__('Untitled #%s', 'HJYL_HILAU'),get_the_date('Y-m-d'));
							}else{
								echo wp_trim_words(get_the_title(), 18); 
							}?>
							</a><span class="list_date"><?php echo timeago(get_gmt_from_date(get_the_modified_time('Y-m-d G:i:s'))); ?></span>
						</li>
						<?php endwhile; wp_reset_query(); ?>
					</ul>
				</div>
				<div class="col-xs-12 col-md-4 colnum-5">
					<span><i class="fas fa-list"></i> <?php _e('Rand Posts', 'HJYL_HILAU'); ?></span>
					<ul class="list-unstyled">	
					<?php $rand_posts = get_posts('numberposts=10&orderby=rand&ignore_sticky_posts=1');foreach($rand_posts as $post) : ?> 
						<li>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute( array( 'before' => '', 'after' => '' ) ); ?>">
							<?php if("" == get_the_title()) {
								printf(__('Untitled #%s', 'HJYL_HILAU'),get_the_date('Y-m-d'));
							}else{
								echo wp_trim_words(get_the_title(), 18); 
							} ?></a><span class="list_date"><?php echo timeago(get_gmt_from_date(get_the_time('Y-m-d G:i:s'))); ?></span>
						</li> 
				<?php endforeach;?> 
					</ul>
				</div>
			</div>
			<div class="clearfix"></div>
			<?php } ?>