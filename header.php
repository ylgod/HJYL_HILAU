<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<link rel="dns-prefetch" href="//cdn.bootcss.com" />
	<link rel="dns-prefetch" href="//fonts.gstatic.font.im" />
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php
	$keywords = of_get_option('keywords', '');
	$description = of_get_option('description', '');
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
		$keywords .= ', ' .$tag->name;
	}
} elseif ( is_category() ) {
	$category = get_the_category();
	$keywords = $category[0]->cat_name;
	$description = category_description();
}else{
	$keywords;
	$description;
}
?>
	<meta name="keywords" content="<?php echo $keywords; ?>" />
	<meta name="description" content="<?php echo $description; ?>" />
	<?php wp_head(); ?>
	<?php echo of_get_option('head_code'); ?>
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
			<nav id="hjyl_menu" class="navbar navbar-light bg-light" role="navigation">
				<div class="container">
				<?php
					if(!wp_is_mobile()) {
						wp_nav_menu( array( 'theme_location' => 'primary', 'fallback_cb' => 'hjyl_wp_list_pages', 'container' => false ) );
					}else{
						wp_nav_menu( array( 'theme_location' => 'mobile', 'fallback_cb' => 'hjyl_wp_list_pages', 'container' => false ) );
					}
				?>
				</div>
				<div class="reading-bar"></div>
			</nav>
			<!-- .home top 468*60 start -->
			<?php if(of_get_option('is_home_ad') == 1) : ?>
			<?php if(is_home() && !empty(of_get_option('home_google_ad'))){ ?>
				<figure class="home_google_ad">
				<?php echo of_get_option('home_google_ad'); ?>
				</figure>
			<?php } ?>
			<?php else: ?>
			<?php if(!empty(of_get_option('home_google_ad'))){ ?>
				<figure class="home_google_ad">
				<?php echo of_get_option('home_google_ad'); ?>
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
						<span>
							<?php echo hjyl_get_svg( array( 'icon' => 'user' ) ); ?>
							<?php while(have_posts()){the_post(); the_author_posts_link();} ?>
						</span>
						<?php if(!is_page()){ ?>
						<span class="cat-links" >
							<?php echo hjyl_get_svg( array( 'icon' => 'bars' ) ); ?>
							<?php the_category(', '); ?>
						</span>
						<?php } ?>
						<span class="last-updated" title="<?php printf(__('%s', 'HJYL_HILAU'),the_time('Y-m-d G:i:s')); ?>">
							<?php echo hjyl_get_svg( array( 'icon' => 'time' ) ); ?>
							<?php printf(__('%s', 'HJYL_HILAU'),timeago(get_gmt_from_date(get_the_time('Y-m-d G:i:s')))); ?>
						</span>
						<span>
						<?php echo hjyl_get_svg( array( 'icon' => 'comment' ) ); ?>
						<?php comments_popup_link( __( 'Leave a reply', 'HJYL_HILAU' ), __( '1 Comment', 'HJYL_HILAU' ), __( '% Comments', 'HJYL_HILAU' ),'comments-views',__( 'Comments Off', 'HJYL_HILAU' ) ); ?>
						</span>
						<?php edit_post_link( __( 'Edit', 'HJYL_HILAU' ), '<span class="edit-link">'.hjyl_get_svg( array( 'icon' => 'edit' ) ).'', '</span>' ); ?>
						<?php while(have_posts()){the_post(); the_tags('<p class="tags">'.hjyl_get_svg( array( 'icon' => 'tags' ) ).'', ', ', '</p>'); } ?>
					</div>
				<?php } ?>
				</div><!-- .slideNav -->
			</div><!-- #slide -->
		</header>
		<?php get_template_part( 'inc/header', 'breadcrumb'); ?>