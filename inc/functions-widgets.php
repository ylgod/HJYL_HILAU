<?php
/*hot posts*/
class Heat extends WP_Widget
{
    function __construct(){
        $widget_ops = array('description' => __('Hot Posts','HJYL_HILAU'));
        parent::__construct('Heat' ,__('Hot Posts','HJYL_HILAU'), $widget_ops);
    }
    function form($instance){
		$instance = wp_parse_args((array)$instance,array('title'=>__('Hot Posts','HJYL_HILAU'), 'Heat'=>'10'));
		$title = htmlspecialchars($instance['title']);
		$Heat = htmlspecialchars($instance['Heat']);

		echo '<p style="text-align:left;"><label for="'.$this->get_field_name('title').'">'.__('title:','HJYL_HILAU').'<input style="width:220px;" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.$title.'" /></label></p>';
		echo '<p style="text-align:left;"><label for="'.$this->get_field_name('Heat').'">'.__('Max Num:','HJYL_HILAU').'<input style="width:220px;" id="'.$this->get_field_id('Heat').'" name="'.$this->get_field_name('Heat').'" type="text" value="'.$Heat.'" /></label></p>';
	}
	function update($new_instance,$old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['Heat'] = strip_tags(stripslashes($new_instance['Heat']));
		return $instance;
    }
   function widget($args,$instance){
	  extract($args);
	  $title = apply_filters('widget_title',empty($instance['title']) ? __('Hot Posts','HJYL_HILAU') : $instance['title']);
	  $Heat = empty($instance['Heat']) ? '10' : $instance['Heat'];


	  echo '<li class="widget widget_recent_entries">';
	  echo $before_title . $title . $after_title;
	  ?>
		 

	<ul>	
			
<?php
global $wpdb;
 $pop = $wpdb->get_results("SELECT id, post_title, post_date, comment_count FROM {$wpdb->prefix}posts WHERE post_type='post' AND post_status='publish' AND post_password='' ORDER BY comment_count DESC LIMIT ".$Heat.""); 
?>
<?php foreach($pop as $post) : ?>
<li><a href="<?php echo get_permalink($post->id); ?>" title="<?php $post_title=$post->post_title; if($post_title==''){$post_title=sprintf(__('Untitled #%s', 'HJYL_HILAU'),date('Y-m-d',strtotime($post->post_date)));} echo $post_title; ?>"><?php echo $post_title; ?></a></li>
<?php endforeach; ?>
			
		</ul>

	  <?php 
	  echo $after_widget;
   }
}

/*related posts*/
class Related extends WP_Widget
{
    function __construct(){
        $widget_ops = array('description' => __('Related Posts','HJYL_HILAU'));
        parent::__construct('Related' ,__('Related Posts','HJYL_HILAU'), $widget_ops);
    }
    function form($instance){
		$instance = wp_parse_args((array)$instance,array('title'=>__('Related Posts','HJYL_HILAU'), 'Related'=>'10'));
		$title = htmlspecialchars($instance['title']);
		$Related = htmlspecialchars($instance['Related']);

		echo '<p style="text-align:left;"><label for="'.$this->get_field_name('title').'">'.__('title:','HJYL_HILAU').'<input style="width:220px;" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.$title.'" /></label></p>';
		echo '<p style="text-align:left;"><label for="'.$this->get_field_name('Related').'">'.__('Max Num:','HJYL_HILAU').'<input style="width:220px;" id="'.$this->get_field_id('Related').'" name="'.$this->get_field_name('Related').'" type="text" value="'.$Related.'" /></label></p>';
	}
	function update($new_instance,$old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['Related'] = strip_tags(stripslashes($new_instance['Related']));
		return $instance;
    }
   function widget($args,$instance){
	  extract($args);
	  $title = apply_filters('widget_title',empty($instance['title']) ? __('Related Posts','HJYL_HILAU') : $instance['title']);
	  $Related = empty($instance['Related']) ? '10' : $instance['Related'];


	  echo '<li class="widget widget_recent_entries">';
	  echo $before_title . $title . $after_title;
	  ?>
		 

	<ul>	
		<?php
		global $post;
		$tags = wp_get_post_tags($post->ID);
		if ($tags) {
			$tag_list = '';
			foreach($tags as $tagsin){
				$tag_list .= $tagsin->term_id . ',';
			}
		$args=array(
		'tag__in' => explode(',', $tag_list),
		'post__not_in' => array($post->ID),
		'showposts'=>$Related,
		'ignore_sticky_posts'=>1
		);
		$my_query = new WP_Query($args);
		if( $my_query->have_posts() ) {
		while ($my_query->have_posts()) : $my_query->the_post(); ?>
		<li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php if(""==get_the_title() ) { sprintf(__('Untitled #%s', 'HJYL_HILAU'),get_the_date('Y-m-d'));}else{ the_title();} ?></a></li>
		<?php
		endwhile;
		}
		}
		wp_reset_query();
		?>
	</ul>

	  <?php 
	  echo $after_widget;
   }
}

/*Rand posts*/
class Randposts extends WP_Widget
{
    function __construct(){
        $widget_ops = array('description' => __('Rand Posts','HJYL_HILAU'));
        parent::__construct('Randposts' ,__('Rand Posts','HJYL_HILAU'), $widget_ops);
    }
    function form($instance){
		$instance = wp_parse_args((array)$instance,array('title'=>__('Rand Posts','HJYL_HILAU'), 'Rand'=>'10'));
		$title = htmlspecialchars($instance['title']);
		$Rand = htmlspecialchars($instance['Rand']);

		echo '<p style="text-align:left;"><label for="'.$this->get_field_name('title').'">'.__('title:','HJYL_HILAU').'<input style="width:220px;" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.$title.'" /></label></p>';
		echo '<p style="text-align:left;"><label for="'.$this->get_field_name('Rand').'">'.__('Max Num:','HJYL_HILAU').'<input style="width:220px;" id="'.$this->get_field_id('Rand').'" name="'.$this->get_field_name('Rand').'" type="text" value="'.$Rand.'" /></label></p>';
	}
	function update($new_instance,$old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['Rand'] = strip_tags(stripslashes($new_instance['Rand']));
		return $instance;
    }
   function widget($args,$instance){
	  extract($args);
	  $title = apply_filters('widget_title',empty($instance['title']) ? __('Rand Posts','HJYL_HILAU') : $instance['title']);
	  $Rand = empty($instance['Rand']) ? '10' : $instance['Rand'];


	  echo '<li class="widget widget_recent_entries">';
	  echo $before_title . $title . $after_title;
	  ?>
		 

	<ul>	
			
			<?php

 query_posts('posts_per_page='.$Rand.'&ignore_sticky_posts=1&orderby=rand'); 

while ( have_posts() ) : the_post();
	echo '<li>';
	echo '<a href="';
	the_permalink(); 
	echo '"title="';
	the_title();
	echo '">';
	if(''==get_the_title()){
		printf(__('Untitled #%s', 'HJYL_HILAU'),get_the_date('Y-m-d'));
	}else{
		the_title();
	}
	echo '</a>';
	echo '</li>';
endwhile;

wp_reset_query();

?>
			
		</ul>

	  <?php 
	  echo $after_widget;
   }
}

/*website count*/
class analytics extends WP_Widget
{
    function __construct(){
        $widget_ops = array('description' => __('Website stat','HJYL_HILAU'));
        parent::__construct('analytics' ,__('Website stat','HJYL_HILAU'), $widget_ops);
    }
    function form($instance){
		$instance = wp_parse_args((array)$instance,array('title'=>__('Website stat','HJYL_HILAU'),'Date'=>'2011-3-10'));
		$title = htmlspecialchars($instance['title']);
		$Date = htmlspecialchars($instance['Date']);
		echo '<p style="text-align:left;"><label for="'.$this->get_field_name('title').'">'.__('title:','HJYL_HILAU').'<input style="width:220px;" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.$title.'" /></label></p>';
		echo '<p style="text-align:left;"><label for="'.$this->get_field_name('Date').'">'.__('start time:','HJYL_HILAU').'<input style="width:220px;" id="'.$this->get_field_id('Date').'" name="'.$this->get_field_name('Date').'" type="text" value="'.$Date.'" /></label></p>';
	
	}
	function update($new_instance,$old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['Date'] = strip_tags(stripslashes($new_instance['Date']));
		return $instance;
    }
   function widget($args,$instance){
		extract($args);
		$title = apply_filters('widget_pages',empty($instance['title']) ? __('Website stat','HJYL_HILAU') : $instance['title']);
		$Date = apply_filters('widget_pages',empty($instance['Date']) ? 'N/A' : $instance['Date']);

		echo '<li class="widget widget_count">';
		echo $before_title . $title . $after_title;
	  ?>
<ul>
<li title="<?php global $wpdb; $count_posts = wp_count_posts(); $published_posts = $count_posts->publish; printf(__('Posts Nums %s units', 'HJYL_HILAU'), $published_posts); ?>"><i><?php echo $published_posts; ?></i><?php echo hjyl_get_svg( array( 'icon' => 'thumb-tack' ) ); ?></li>
<li title="<?php $comment_nums = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments"); printf(__('Comments Nums %s units', 'HJYL_HILAU'), $comment_nums); ?>"><i><?php echo $comment_nums; ?></i><?php echo hjyl_get_svg( array( 'icon' => 'comment' ) ); ?></li>
<li title="<?php $web_age = floor((time()-strtotime($Date))/86400); printf(__('Website age %s days', 'HJYL_HILAU'), $web_age); ?>"><i><?php echo $web_age; ?></i><?php echo hjyl_get_svg( array( 'icon' => 'time' ) ); ?></li>
<li title="<?php $count_tags = wp_count_terms('post_tag'); printf(__('Tags Nums %s units', 'HJYL_HILAU'), $count_tags); ?>"><i><?php echo $count_tags; ?></i><?php echo hjyl_get_svg( array( 'icon' => 'tags' ) ); ?></li>
</ul>
<p class="clearfix"></p>




	  <?php 
	  echo $after_widget;
   }
}

/*recent comments [include gravatar]*/
class hjyl_Comment extends WP_Widget
{
    function __construct(){
        $widget_ops = array('description' => __('Recent Comments For Gravatar','HJYL_HILAU'));
        parent::__construct('hjyl_Comment' ,__('Recent Comments For Gravatar','HJYL_HILAU'), $widget_ops);
    }
    function form($instance){
		$instance = wp_parse_args((array)$instance,array('title'=>__('Recent Comments','HJYL_HILAU'),'Comment'=>'8'));
		$title = htmlspecialchars($instance['title']);
		$Comment = htmlspecialchars($instance['Comment']);

		echo '<p style="text-align:left;"><label for="'.$this->get_field_name('title').'">'.__('title:','HJYL_HILAU').'<input style="width:220px;" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.$title.'" /></label></p>';
		echo '<p style="text-align:left;"><label for="'.$this->get_field_name('Comment').'">'.__('Max Num:','HJYL_HILAU').'<input style="width:220px;" id="'.$this->get_field_id('Comment').'" name="'.$this->get_field_name('Comment').'" type="text" value="'.$Comment.'" /></label></p>';
}
	function update($new_instance,$old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['Comment'] = strip_tags(stripslashes($new_instance['Comment']));
		return $instance;
    }
   function widget($args,$instance){
	  extract($args);
	  $title = apply_filters('widget_title',empty($instance['title']) ? __('Recent Comments','HJYL_HILAU') : $instance['title']);
	  $Comment = empty($instance['Comment']) ? '10' : $instance['Comment'];

	  echo '<li class="widget widget_comment">';
	  echo $before_title . $title . $after_title;
	  ?>
	
<ul class="recentcomments">
<?php
global $wpdb;
$my_email = get_bloginfo ('admin_email');
$rc_comms = $wpdb->get_results("
  SELECT ID, post_title, post_date, comment_ID, comment_author, comment_author_email, comment_content, comment_author_url
  FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts
  ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID)
  WHERE comment_approved = '1'
  AND comment_type = ''
  AND user_id='0'
  AND post_password = ''
  AND comment_author_email != '$my_email'
  ORDER BY comment_date_gmt
  DESC LIMIT ".$Comment."
");
$rc_comments = '';

global $options;

foreach ($rc_comms as $rc_comm) {
	$post_title = $rc_comm->post_title;
	if(''==$post_title){$post_title = sprintf(__('Untitled #%s', 'HJYL_HILAU'),date('Y-m-d', strtotime($rc_comm->post_date)));};
$rc_comments .= "<li><span><a rel='external nofollow' target='_blank' href='". $rc_comm->comment_author_url . "' title='" . $rc_comm->comment_author . "'>" . get_avatar($rc_comm,$size='32',$default='',$alt=''. $rc_comm->comment_author .'') ."</a></span><span class='comment_content'><a href='". get_permalink($rc_comm->ID) . "#comment-" . $rc_comm->comment_ID. "' title=' " . $rc_comm->comment_author . sprintf(__('comments at < %s >', 'HJYL_HILAU'), $post_title)."'>". $post_title ."</a><br />". strip_tags($rc_comm->comment_content). "</span></li><p class='clearfix'></p>";
}
$rc_comments = convert_smilies($rc_comments);
echo $rc_comments;

?></ul>
		

	  <?php 
	  echo $after_widget;
   }
}

/*Comments Wall*/
class Wall extends WP_Widget
{
    function __construct(){
        $widget_ops = array('description' => __('Comments Wall For Gravatar','HJYL_HILAU'));
        parent::__construct('Wall' ,__('Comments Wall For Gravatar','HJYL_HILAU'), $widget_ops);
    }
    function form($instance){
		$instance = wp_parse_args((array)$instance,array('title'=>__('Comments Wall','HJYL_HILAU'),'Comment'=>'1','Wall'=>'18'));
		$title = htmlspecialchars($instance['title']);
		$Comment = htmlspecialchars($instance['Comment']);
		$Wall = htmlspecialchars($instance['Wall']);
		echo '<p style="text-align:left;"><label for="'.$this->get_field_name('title').'">'.__('title:','HJYL_HILAU').'<input style="width:220px;" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.$title.'" /></label></p>';
		echo '<p style="text-align:left;"><label for="'.$this->get_field_name('Comment').'">'.__('How many months:','HJYL_HILAU').'<input style="width:220px;" id="'.$this->get_field_id('Comment').'" name="'.$this->get_field_name('Comment').'" type="text" value="'.$Comment.'" /></label></p>';
		echo '<p style="text-align:left;"><label for="'.$this->get_field_name('Wall').'">'.__('Max Num:','HJYL_HILAU').'<input style="width:220px;" id="'.$this->get_field_id('Wall').'" name="'.$this->get_field_name('Wall').'" type="text" value="'.$Wall.'" /></label></p>';
}
	function update($new_instance,$old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['Comment'] = strip_tags(stripslashes($new_instance['Comment']));
		$instance['Wall'] = strip_tags(stripslashes($new_instance['Wall']));
		return $instance;
    }
   function widget($args,$instance){
	  extract($args);
	  $title = apply_filters('widget_title',empty($instance['title']) ? __('Comments Wall','HJYL_HILAU') : $instance['title']);
	  $Comment = empty($instance['Comment']) ? 'N/A' : $instance['Comment'];
	  $Wall = empty($instance['Wall']) ? '10' : $instance['Wall'];
	  echo '<li class="widget widget_wall">';
	  echo $before_title . $title . $after_title;
	  ?>
	



<ul class="ffox_most_active">

<?php
    global $wpdb;
    $counts = $wpdb->get_results("SELECT COUNT(comment_author) AS cnt, comment_author, comment_author_url, comment_author_email
        FROM {$wpdb->prefix}comments
        WHERE comment_date > date_sub( NOW(), INTERVAL ".$Comment." MONTH )
            AND comment_approved = '1'
            AND comment_author_email != 'example@example.com'
            AND comment_author_url != ''
            AND comment_type = ''
            AND user_id = '0'
        GROUP BY comment_author_email
        ORDER BY cnt DESC
        LIMIT ".$Wall."");

    $mostactive = '';
    if ( $counts ) {     
        foreach ($counts as $count) {
            $c_url = $count->comment_author_url;
            $mostactive .= '<li class="float-left">' . '<a rel="nofollow" href="'. $c_url . '" title="'.sprintf(__('%1$s replied %2$s comments','HJYL_HILAU'), $count->comment_author, $count->cnt ).'" target="_blank">' . get_avatar($count->comment_author_email, 32, '', sprintf(__('%1$s replied %2$s comments','HJYL_HILAU'), $count->comment_author, $count->cnt )) . '</a></li>';
        }
        echo $mostactive;
    }
?>
</ul>
<p class="clearfix"></p>


	  <?php 
	  echo $after_widget;
   }
}
function hjyl_register_widgets(){
	register_widget("Heat");             //热门文章
	register_widget("Related");         //相关文章
	register_widget("Randposts");      //随机文章
	register_widget("analytics");     //博客统计
	register_widget("hjyl_Comment"); //带头像的最新评论
	register_widget("Wall");        //读者墙
}
add_action('widgets_init','hjyl_register_widgets');

