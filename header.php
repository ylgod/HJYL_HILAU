<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<link rel="dns-prefetch" href="https://cdn.bootcss.com" />
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php
$options = get_theme_mod('hjyl_hilau_options');
	$keywords = isset($options['keywords'] ) ? $options['keywords'] : '';
	$description = isset($options['description'] ) ? $options['description'] : '';
if(is_singular()){
	if ($post->post_excerpt) {
		$description     = $post->post_excerpt;
	} else {
		$description = wp_trim_words(strip_tags($post->post_content),220);
	}
	if (!is_single()){
	$keywords = get_the_title().', ';  
	}
	$tags = wp_get_post_tags($post->ID);
	foreach ($tags as $tag ) {
		$keywords .= $tag->name . ', ';
	}
} elseif ( is_category() ) {
	$category = get_the_category();
	$keywords = $category[0]->cat_name;
	$description = category_description();
}else{
	$keywords = isset($options['keywords'] ) ? $options['keywords'] : '';
	$description = isset($options['description'] ) ? $options['description'] : '';
}
?>
	<meta name="keywords" content="<?php echo $keywords; ?>" />
	<meta name="description" content="<?php echo $description; ?>" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
	<div id="warpper" class="container">
		<header>
			<div id="topbar" class="top-bar">
				<div class="topNav">
				<?php if ( has_custom_logo() ) : ?>
					<div class="site-logo"><?php the_custom_logo(); ?></div>
					<h1 class="hjyl-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else: ?>
				<?php $blog_info = get_bloginfo( 'name' ); ?>
				<?php if ( ! empty( $blog_info ) ) : ?>
					<span class="spanNav"></span><h1 class="site-title" id="hjyl_logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php endif; ?>
				<?php endif; ?>

				</div><!-- .topNav -->
			<?php if ( has_nav_menu( 'top-menu' ) ) : ?>
			<nav class="navbar navbar-expand-md navbar-light bg-light justify-content-end" role="navigation">
				<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-controls="bs-example-navbar-collapse-1" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
					<?php
					wp_nav_menu( array(
						'theme_location'    => 'top-menu',
						'depth'             => 2,
						'container'         => 'div',
						'container_class'   => 'collapse navbar-collapse',
						'container_id'      => 'bs-example-navbar-collapse-1',
						'menu_class'        => 'nav navbar-nav',
						'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
						'walker'            => new WP_Bootstrap_Navwalker(),
					) );
					?>
				</div>
			</nav>
			<?php endif; ?>
			<!-- .home top 468*60 start -->
			<?php if(!empty($options['is_home_ad']) && $options['is_home_ad'] == 1) : ?>
			<?php if(is_home() && !empty($options['home_google_ad'])){ ?>
				<figure class="home_google_ad">
				<?php echo $options['home_google_ad']; ?>
				</figure>
			<?php } ?>
			<?php else: ?>
			<?php if(!empty($options['home_google_ad'])){ ?>
				<figure class="home_google_ad">
				<?php echo $options['home_google_ad']; ?>
				</figure>
			<?php } ?>
			<?php endif; ?>

			
			<!-- .home top 468*60 end -->
			</div><!-- #topbar -->
			
			<div id="slide">
				<div class="slideNav">
				<?php if (!is_singular() ) {	?>
				<?php if (is_active_sidebar( 'search' ) ) {	?>
					<div class="search-widget">
						<?php dynamic_sidebar( 'search' ); ?>
					</div>
				<?php } }else{ ?>
					<div class="single-widget">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
						<span class="fas fa-user author">
							<?php while(have_posts()){the_post(); the_author_posts_link();} ?>
						</span>
						<?php if(!is_page()){ ?>
						<span class="fas fa-flag cat-links" >
							<?php the_category(', '); ?>
						</span>
						<?php } ?>
						<span class="fas fa-clock last-updated" title="<?php printf(__('%s', 'HJYL_HILAU'),the_time('Y-m-d G:i:s')); ?>">
							<?php printf(__('%s', 'HJYL_HILAU'),timeago(get_gmt_from_date(get_the_time('Y-m-d G:i:s')))); ?>
						</span>
						<?php comments_popup_link( __( ' Leave a reply', 'HJYL_HILAU' ), __( ' 1 Comment ', 'HJYL_HILAU' ), __( ' % Comments', 'HJYL_HILAU' ),'fas fa-comments comments-views',__( ' Comments Off', 'HJYL_HILAU' ) ); ?>
						<?php edit_post_link( __( 'Edit', 'HJYL_HILAU' ), '<span class="fa fa-pencil-square-o edit-link"> ', '</span>' ); ?>
						<?php while(have_posts()){the_post(); the_tags('<p class="tags"><i class="fas fa-tags"></i> ', ', ', '</p>'); } ?>
					</div>
				<?php } ?>
				</div><!-- .slideNav -->
			</div><!-- #slide -->
		</header>
		<?php get_template_part( 'inc/header', 'breadcrumb'); ?>