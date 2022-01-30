<?php 
/*
Template Name: 下载页面
伪静态设置：rewrite ^/download/([^\?]+)$ /download?pid=$1 last;
*/
$options = get_theme_mod( 'hjyl_hilau_options');
$pid = isset( $_GET['pid'] ) ? trim(htmlspecialchars($_GET['pid'], ENT_QUOTES)) : '';
if( !$pid ) { wp_redirect( home_url() );}
$title = get_the_title($pid);
$values1 = get_post_custom_values('hjyl_download_name',$pid);
empty($values1) ? Header('Location:/') : $theCode1 = $values1[0];
$values2 = get_post_custom_values('hjyl_download_size',$pid);
empty($values2) ? Header('Location:/') : $theCode2 = $values2[0];
$values3 = get_post_custom_values('hjyl_download_link',$pid);
empty($values3) ? Header('Location:/') : $theCode3 = $values3[0];
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<link rel="dns-prefetch" href="//cdn.bootcss.com" />
	<link rel="dns-prefetch" href="//fonts.gstatic.font.im" />
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="<?php echo $title; ?>, <?php echo $theCode1; ?>, <?php printf(__('Free Resources, Download Page', 'HJYL_HILAU')); ?>" />
	<meta name="description" content="<?php printf(__('The download page for the resource named "%1$s" in the article of %2$s', 'HJYL_HILAU'), $theCode1, $title); ?>" />
	<title><?php printf(__('The download page for %s', 'HJYL_HILAU'), $theCode1); ?> &#8211; <?php bloginfo( 'name' ); ?></title>
<link rel='stylesheet' id='hjyl-hilau-css'  href='<?php echo get_stylesheet_uri(); ?>' type='text/css' media='all' />
<link rel='stylesheet' id='bootstrap-css'  href='//cdn.staticfile.org/twitter-bootstrap/4.6.1/css/bootstrap.min.css?ver=20220130' type='text/css' media='all' />
<script src='//cdn.staticfile.org/jquery/3.6.0/jquery.min.js?ver=20220130'></script>
<script src='//cdn.staticfile.org/twitter-bootstrap/4.6.1/js/bootstrap.min.js?ver=20220130'></script>
<script src='<?php echo esc_url(get_template_directory_uri()); ?>/js/hjyl.js'></script>
<?php if ( !has_custom_logo() ) : ?>
<script type='text/javascript' src='<?php echo esc_url(get_template_directory_uri()); ?>/js/logo.js'></script>
<?php endif; ?>
<?php echo custom_login_head(); ?>
<?php if(has_site_icon()) { wp_site_icon(); }?>
<style type="text/css">
#filelink a{margin:0 10px;}
#breadcrumb a, #footer a{color:rgba(116,127,140,1)!important;font-weight:400;}
</style>
</head>

<body <?php body_class(); ?>>
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
					<div class="single-widget">
					<h1 class="entry-title"><?php printf(__('The download page for %s', 'HJYL_HILAU'), $theCode1); ?></h1>
					</div>
				</div><!-- .slideNav -->
			</div><!-- #slide -->
		</header>
<?php get_template_part( 'inc/header', 'breadcrumb'); ?>
	<section id="primary" class="content-area row">
		<main id="main" class="site-main col-xs-12 col-md-12 col-lg-12">
			<?php if(have_posts()) : ?>
			<?php while(have_posts()) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content">
				<div class="row">
					<div class="col-xs-12 col-md-4 col-lg-4">
					<?php 
						if(!empty($options['single_google_ad'])){
						echo '<figure class="page_download_ad">';
							echo $options['single_google_ad'];
						echo '</figure>';
						}
					?>
					</div>
					<div class="col-xs-12 col-md-8 col-lg-8">
						<h3><?php _e('Download Info', 'HJYL_HILAU'); ?></h3>
						<div class="alert alert-success">
						<ul class="infos clearfix">
							<li><?php printf(__('Download Name: %s', 'HJYL_HILAU'), $theCode1); ?></li>
							<li><?php printf(__('Download Size: %s', 'HJYL_HILAU'), $theCode2); ?></li>
							<li><?php printf(__('Update Time: %s', 'HJYL_HILAU'), get_post($pid)->post_modified); ?></li>
							</ul>
						</div>
                    <h3><?php _e('Download Link', 'HJYL_HILAU'); ?></h3>
                    <div id="filelink">
                        <center>
                        <?php
                            if ($theCode3) {
                                $hjyl_download_links = explode("\n", $theCode3);
                                foreach ($hjyl_download_links as $hjyl_download_link) {
                                    $hjyl_download_link = explode("   ", $hjyl_download_link);
                                    $hjyl_dlink = '<a class="btn btn-outline-primary" href="' . trim($hjyl_download_link[0]) . '"target="_blank" rel="nofollow" data-original-title="' . esc_attr(trim($hjyl_download_link[2])) . '" title="' . esc_attr(trim($hjyl_download_link[2])) . '">' . trim($hjyl_download_link[1]) . '</a>';
									echo the_content_nofollow($hjyl_dlink); //与go跳转相结合
                                    }
                                }
                        ?>
                        </center>
                    </div>
					</div>
				</div>
                    <div class="clearfix"></div>
                    <h3><?php _e('Download Note', 'HJYL_HILAU'); ?></h3>
                    <div class="alert alert-info" role="alert">
						<?php _e('<p>1.If the downloaded file is in compressed package format, please install RAR or other software to decompress it.<br />2.When files are large, download tools are recommended. Browser downloads sometimes interrupt automatically. Baidu Netdisks recommend PanDownload software or its webpage version for download.<br />3.Resources may be harmony due to content issues, leading to the unavailability of download links. If you encounter this problem, please go to the article page for feedback, and we will update it in time.<br />4.If you have any other questions or suggestions, please leave a comment.</p>', 'HJYL_HILAU'); ?>
					</div>
                    <h2><?php _e('Download Disclaimer', 'HJYL_HILAU'); ?></h2>
                    <div class="alert alert-warning" role="alert"><?php _e('Download Disclaimer: Some resources of this website are collected on the Internet for your study and reference only. If there is any infringement, please contact the administrator to delete it in time.', 'HJYL_HILAU'); ?></div>
				</div><!-- .entry-content -->
				</article>

				<div class="clearfix"></div>
			<?php endwhile; else : ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>><?php get_template_part( 'inc/content', 'none'); ?></article>
			<?php endif; ?>
		</main>
	</section>
	
<?php get_footer(); ?>