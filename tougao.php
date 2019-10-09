<?php 
/*
Template Name: 投稿
*/
get_header();
$options = get_theme_mod( 'hjyl_hilau_options');
?>
<script type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
  tinymce.init({
    selector : '#tougao_content',
	menubar: false,
	//toolbar: false,
});
</script>
<style type="text/css">
	#content form input,.t6 #cat{width:250px;height:30px;padding:0 10px;}
	#postform{width:100%;padding:0 15px;}
</style>
	<section id="primary" class="content-area row">
		<main id="main" class="site-main col-xs-12 col-md-12 col-lg-12">
			<?php if(have_posts()) : ?>
			<?php while(have_posts()) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content">
				<?php
					if(!empty($options['singlar_google_ad'])){
					echo '<figure class="singlar_google_ad mx-auto">';
						echo $options['singlar_google_ad'];
					echo '</figure>';
					}
					the_content();
					wp_link_pages( array( 'before' => '<nav class="page-link"><i class="fa fa-folder-open" aria-hidden="true"></i> <span>' . __( 'Pages:', 'HJYL_HILAU' ) . '</span>', 'after' => '</nav>' ) );
				?>
				</div><!-- .entry-content -->
						<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; $current_user = wp_get_current_user(); ?>" class="row">
						<div class="t1 tt col-sm-4">
							<span>
								<input class="form-control" type="text" size="40" value="<?php if ( 0 != $current_user->ID ) echo $current_user->user_login;?>" name="tougao_authorname"; id="tougao_authorname" tabindex="1" />
							</span>
							<span>
								<label>您的昵称(不超20字)</label>
							</span>
						</div>
						<div class="t2 tt col-sm-4">
							<span>
								<input class="form-control" type="text" size="40" value="<?php if ( 0 != $current_user->ID ) echo $current_user->user_email;?>" name="tougao_authoremail" id="tougao_authoremail" tabindex="2" />
							</span>
							<span>
								<label>您的邮箱</label>
							</span>
						</div>
						<div class="t3 tt col-sm-4">
							<span>
								<input class="form-control" type="text" size="40" value="<?php if ( 0 != $current_user->ID ) echo $current_user->user_url;?>" name="tougao_site" id="tougao_site" tabindex="4" />
							</span>
							<span>
								<label>贵站网址</label>
							</span>
						</div>
						<div class="t4 tt col-sm-4">
							<span>
								<input class="form-control" type="text" size="40" value="" name="tougao_title" id="tougao_title" tabindex="3" />
							</span>
							<span>
								<label>文章标题（6到50字之间）</label>
							</span>
						</div>
						<div class="t5 tt col-sm-4">
							<span>
								<input class="form-control" type="text" size="40" value="" name="tougao_tags" id="tougao_tags" tabindex="5" />
							</span>
							<span>
								<label>文章标签（2到20字之间并以英文逗号分开）</label>
							</span>
						</div>
						<div class="t6 tt col-sm-4">
							<span>
								<?php wp_dropdown_categories('title_li=0&hierarchical=1&hide_empty=0'); ?>
							</span>
							<span>
								<label>文章分类*(必选)</label>
							</span>
						</div>
						<div class="clear"></div>
						<div id="postform">
							<textarea rows="15" cols="70"  class="form-control col-sm-12" id="tougao_content" name="tougao_content" tabindex="6" /></textarea>
							<p>字数限制：300到10000字之间</p>
						</div>
						<div class="col-sm-12" id="submit_post">
							<input type="hidden" value="send" name="tougao_form" />
							<input class="btn btn-danger" type="submit" name="submit" value="发表文章" tabindex="7" />
							<input class="btn btn-outline-secondary" type="reset" name="reset" value="重填内容" tabindex="8" />
						</div>
						</form>
				</article>

				<div class="clearfix"></div>
			<?php endwhile; else : ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>><?php get_template_part( 'inc/content', 'none'); ?></article>
			<?php endif; ?>
		</main>
	</section>
	
<?php get_footer(); ?>