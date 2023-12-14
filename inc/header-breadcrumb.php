			<nav id="breadcrumb" class="row">
				<ol class="breadcrumb col-xs-12 col-md-8">
					<li class="breadcrumb-item">
						<?php echo hjyl_get_svg( array( 'icon' => 'home' ) ); ?> <a href="<?php echo esc_url(home_url()); ?>"><?php _e('Home', 'HJYL_HILAU'); ?></a>
					</li>
					
					<?php if(is_single()) {?>
					<li class="breadcrumb-item">
						<?php the_category(', '); ?>
					</li>
					<?php } ?>
					
					<li class="breadcrumb-item">
					<?php
					/* If this is a tag archive */
					if(is_category()) {
						single_cat_title();
					/* If this is a search result */
					} elseif (is_search()) {
						printf( __( 'Search Results for: %s', 'HJYL_HILAU' ), get_search_query() );
					/* If this is a tag archive */
					} elseif(is_tag()) {
						single_tag_title();
					/* If this is a daily archive */
					} elseif (is_day()) {
						the_time( 'Y, F jS' );
					/* If this is a monthly archive */
					} elseif (is_month()) {
						the_time( 'Y, F' );
					/* If this is a yearly archive */
					} elseif (is_year()) {
						the_time( 'Y' );
					/* If this is a single */
					} elseif (is_singular()) {
						if(""!==get_the_title() ) {
							the_title();
						}else{
							printf(__('Untitled #%s', 'HJYL_HILAU'),get_the_date('Y-m-d'));
						}
					/* If this is Error 404 */
					} elseif (is_404()) {
						_e('404 Error', 'HJYL_HILAU');	
					} elseif ( is_author() ) {
						printf(__( 'Author "%s" as followed', 'HJYL_HILAU' ), get_the_author_meta( 'display_name' ));
					}
					$paged = get_query_var('paged'); if ( $paged > 1 ){
						printf(__(' - Page %s - ', 'HJYL_HILAU'), $paged);
					}
					?>
				  </li>
				  
				</ol>
				  <div class="socialink col-xs-12 col-md-4 alert-warning">
				<?php if(!is_singular()) {?>
					<span><?php _e('Contact : ', 'HJYL_HILAU'); ?></span>
					<?php if(!empty(of_get_option('social_qq'))){ ?>
					<a href="tencent://Message/?Uin=<?php echo of_get_option('social_qq'); ?>&amp;websiteName=hilau.com&amp;Menu=yes"><span class="tooltiptext"><?php _e('Follow me on QQ', 'HJYL_HILAU'); ?></span><?php echo hjyl_get_svg( array( 'icon' => 'qq' ) ); ?><span class="rotate"></span></a>
					<?php } ?>
					<?php if(!empty(of_get_option('social_weibo'))){ ?>
					<a href="https://weibo.com/<?php echo of_get_option('social_weibo'); ?>?is_all=1"><span class="tooltiptext"><?php _e('Follow me on Weibo', 'HJYL_HILAU'); ?></span><?php echo hjyl_get_svg( array( 'icon' => 'weibo' ) ); ?><span class="rotate"></span></a>
					<?php } ?>
					<?php if(!empty(of_get_option('social_wechat'))){ ?>
					<a href="#" class="bds_weixin"><span class="tooltiptext"><img width="180" height="180" src="<?php echo of_get_option('social_wechat'); ?>" alt="<?php _e('Follow me on weChat', 'HJYL_HILAU'); ?>"></span><?php echo hjyl_get_svg( array( 'icon' => 'qrcode' ) ); ?><span class="rotate"></span></a>
					<?php } ?>
					<?php if(!empty(of_get_option('social_mail'))){ ?>
					<a href="mailto:<?php echo of_get_option('social_mail'); ?>"><span class="tooltiptext"><?php _e('Follow me on Email', 'HJYL_HILAU'); ?></span><?php echo hjyl_get_svg( array( 'icon' => 'email' ) ); ?><span class="rotate"></span></a>
					<?php } ?>
				<?php }else{ ?>
					<div class="share-button">
						<span><?php _e('Share To : ', 'HJYL_HILAU'); ?></span>
						<a href="#" class="bds_weixin" data-cmd="weixin" title="<?php _e('Share me on WeChat', 'HJYL_HILAU'); ?>"><span class="tooltiptext"><i class="qrcode"></i></span><?php echo hjyl_get_svg( array( 'icon' => 'qrcode' ) ); ?><span class="rotate"></span></a>
						<a target="_blank" href="https://service.weibo.com/share/share.php?url=<?php the_permalink(); ?>&title=<?php the_title(); ?>&pic=&appkey=1867581383&searchPic=true" class="bds_tsina" data-cmd="tsina" title="<?php _e('Share me on Weibo', 'HJYL_HILAU'); ?>"><span class="tooltiptext"><?php _e('Share me on Weibo', 'HJYL_HILAU'); ?></span><?php echo hjyl_get_svg( array( 'icon' => 'weibo' ) ); ?><span class="rotate"></span></a>
						<a target="_blank" href="https://connect.qq.com/widget/shareqq/index.html?url=<?php the_permalink(); ?>&title=<?php the_title(); ?>&desc=&summary=&site=<?php echo esc_url(home_url()); ?>" class="bds_sqq" data-cmd="sqq" title="<?php _e('Share me to QQ Friends', 'HJYL_HILAU'); ?>"><span class="tooltiptext"><?php _e('Share me to QQ Friends', 'HJYL_HILAU'); ?></span><?php echo hjyl_get_svg( array( 'icon' => 'qq' ) ); ?><span class="rotate"></span></a>
						<a target="_blank" href="https://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=<?php the_permalink(); ?>&title=<?php the_title(); ?>&desc=&summary=<?php the_title(); ?>&site=<?php echo esc_url(home_url()); ?>" class="bds_qzone" data-cmd="qzone" title="<?php _e('Share me on Qzone', 'HJYL_HILAU'); ?>"><span class="tooltiptext"><?php _e('Share me on Qzone', 'HJYL_HILAU'); ?></span><?php echo hjyl_get_svg( array( 'icon' => 'qzone' ) ); ?><span class="rotate"></span></a>
					</div>
   
				  </div>
				<?php } ?>
			</nav><!--Breadcrumb-->