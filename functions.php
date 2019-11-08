<?php
/**
 * only works in WordPress 5.0 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '5.0', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}
//检测主题更新 
require get_template_directory() . '/inc/theme-update-checker.php'; 
$hjyl_update_checker = new ThemeUpdateChecker('HJYL_HILAU', 'https://raw.githubusercontent.com/ylgod/HJYL_HILAU/master/check_update.json');

if ( ! function_exists( 'HJYL_HILAU_setup' ) ) :

	function HJYL_HILAU_setup() {
		//Translations can be filed in the /languages/ directory.
		load_theme_textdomain( 'HJYL_HILAU', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		
		//禁止引号半角\全角切换
		remove_filter('the_content', 'wptexturize');
		//hard-coded <title> tag in the document head, and expect WordPress to
		add_theme_support( 'title-tag' );
		add_editor_style('css/bootstrap.min.css');

		//Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );
		add_image_size('slide', 700, 380, true );
		add_image_size('post', 790, 300, true );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'top-menu' => __( 'Top Menu', 'HJYL_HILAU' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		//Add support for core custom logo.
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 100,
				'width'       => 100,
				'flex-width'  => true,
				'flex-height' => true,
				'header-text' => array( 'site-title', 'site-description' ),
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
		
		add_theme_support( "custom-background" );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );


		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );
		
	//del tag p from category_description
	add_filter('category_description', 'HJYL_HILAU_deletehtml');
	
		//评论添加@
	add_filter( 'comment_text' , 'hjyl_comment_add_at', 20, 2);
	}
endif;
add_action( 'after_setup_theme', 'HJYL_HILAU_setup' );

//去掉分类p标签和换行
function HJYL_HILAU_deletehtml($description) { 
	$description = trim($description); 
	$description = strip_tags($description,""); 
	return ($description);
}

// 评论添加@，by Ludou
function hjyl_comment_add_at( $comment_text, $comment = '') {
	global $comment;
	if( $comment->comment_parent > 0) {
		$comment_text = '@<a href="#comment-' . $comment->comment_parent . '">'.get_comment_author( $comment->comment_parent ) . '</a> ' . $comment_text;
	}

	return $comment_text;
}

//Title Tag
add_filter( 'document_title_parts', 'hjyl_document_title_parts', 10, 1 );
function hjyl_document_title_parts( $title ){
	//no title
	if(is_singular() && ""==get_the_title() ) { 
		$title['title'] = sprintf(__('Untitled #%s', 'HJYL_HILAU'),get_the_date('Y-m-d'));
	};
    return $title;
}


//调用bing没图url
function hjyl_img(){
    global $wp_filesystem;
    require_once ( ABSPATH . '/wp-admin/includes/file.php' );
    WP_Filesystem();
    $str = $wp_filesystem ->get_contents('https://cn.bing.com/HPImageArchive.aspx?idx=0&n=1');
    if(preg_match("/<url>(.+?)<\/url>/is",$str,$matches)){
        $imgurl='https://cn.bing.com'.$matches[1];
    }
	return $imgurl;
}

//bing美图自定义页面背景
function hjyl_bg(){
        echo '<style type="text/css">html body{background: url(' . hjyl_img() . ');background-repeat: no-repeat;background-position: top center;background-attachment: fixed;background-size: cover;width: 100%!important;height: 100%!important;}</style>';
}
add_action('wp_head', 'hjyl_bg');

//bing美图自定义登录页面背景
function custom_login_head() {
        if(defined('UM_DIR')){echo '<style type="text/css">#um_captcha{width:170px!important;}</style>';}
        echo '<style type="text/css">#reg_passmail{display:none!important}body{background: url(' . hjyl_img() . ');background-repeat: no-repeat;background-position: top center;background-attachment: fixed;background-size: cover;width: 100%!important;height: 100%!important;}.login label,a {font-weight: bold;}.login-action-register #login{padding: 5% 0 0;}.login p {line-height: 1;}.login form {background:rgba(251,251,251,0.3);margin-top: 10px;padding: 16px 24px 16px;}width:32px;height:32px;-webkit-border-radius:50px;-moz-border-radius:50px;border-radius:50px;}#registerform,#loginform {background-color:rgba(251,251,251,0.3)!important;}.login label,a{color:#000;}form label input{margin-top:10px!important;}@media screen and (max-width:600px){.login-action-register h1 {display: none;}.login-action-register #login{top:50%!important;}}</style>';
}
add_action('login_head', 'custom_login_head');

/*********************************************移除WordPress头部无用代码 开始***********************************************/
//移除WordPress Emoji 开始
remove_action( 'admin_print_scripts' , 'print_emoji_detection_script');
remove_action( 'admin_print_styles' , 'print_emoji_styles');
remove_action( 'wp_head' , 'print_emoji_detection_script', 7);
remove_action( 'wp_print_styles' , 'print_emoji_styles');
remove_filter( 'the_content_feed' , 'wp_staticize_emoji');
remove_filter( 'comment_text_rss' , 'wp_staticize_emoji');
remove_filter( 'wp_mail' , 'wp_staticize_emoji_for_email');
add_filter( 'emoji_svg_url', function(){ return false; } );                         //禁用emoji预解析
//移除WordPress Emoji 结束
remove_action('wp_head','wp_generator');                                          //禁止在head泄露WordPress版本号
remove_action('wp_head', 'rsd_link');                                            //removes EditURI/RSD (Really Simple Discovery) link.
remove_action('wp_head', 'wlwmanifest_link');                                   //removes wlwmanifest (Windows Live Writer) link.
remove_action('wp_head', 'wp_shortlink_wp_head');                              //removes shortlink.
remove_action( 'wp_head', 'feed_links', 2 );                                  //removes feed links.
remove_action('wp_head', 'feed_links_extra', 3 );                            //removes comments feed.
add_filter('rest_enabled', '__return_false');                               //禁用REST API功能代码
add_filter('rest_jsonp_enabled', '__return_false');                        //禁用REST API功能代码
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');              //移除头部Previous 和 Next 文章链接
remove_action( 'wp_head', 'rel_canonical' );                             //移除本页页面链接URL
remove_action( 'wp_head', 'wp_resource_hints', 2 );                     //去除头部的<link rel=’dns-prefetch’ href=’//s.w.org’ />
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );            //移除wp-json链接的代码
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );      //移除wp-json链接的代码
/*********************************************移除WordPress头部无用代码 结束***********************************************/

//自定义登陆logo的url
add_filter('login_headerurl', function(){return home_url();});
add_filter('login_headertext', function(){return get_bloginfo('name');});

//修改WordPress页脚文本
function hjyl_admin_footer() {
	echo '<a target="_blank" href="https://hjyl.org/">皇家元林</a> - QQ：<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=4953363&site=qq&menu=yes">4953363</a> Email：<a href="mailto:i@hjyl.org">i@hjyl.org</a> - <a target="_blank" href="https://hjyl.org/">皇家元林</a>';
}
//后台页脚增加主题作者联系及主题链接等信息
add_filter('admin_footer_text', 'hjyl_admin_footer');

// Add sidebar
function hjyl_widgets(){
    register_sidebar(array(
		'name' =>''.__('Search', 'HJYL_HILAU').'',
		'id' => 'search',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3><span class="star">',
        'after_title' => '</span></h3>',
    ));
    register_sidebar(array(
		'name'=>''.__('Home', 'HJYL_HILAU').'',
		'id' => 'home',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3><span class="star">',
        'after_title' => '</span></h3>',
    ));
    register_sidebar(array(
		'name'=>''.__('Single', 'HJYL_HILAU').'',
		'id' => 'single',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3><span class="star">',
        'after_title' => '</span></h3>',
    ));
    register_sidebar(array(
		'name'=>''.__('Pages', 'HJYL_HILAU').'',
		'id' => 'page',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3><span class="star">',
        'after_title' => '</span></h3>',
    ));
    register_sidebar(array(
		'name'=>''.__('404', 'HJYL_HILAU').'',
		'id' => 'error',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3><span class="star">',
        'after_title' => '</span></h3>',
    ));
	register_sidebar(array(
		'name'=>''.__('Other', 'HJYL_HILAU').'',
		'id' => 'other',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3><span class="star">',
        'after_title' => '</span></h3>',
    ));
}
add_action( 'widgets_init', 'hjyl_widgets' );

/**
 * @global int $content_width Content width.
 */
function hjyl_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'hjyl_content_width', 640 );
}
add_action( 'after_setup_theme', 'hjyl_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function hjyl_script() {
	wp_enqueue_style( 'hjyl-hilau', get_stylesheet_uri(), array(), '20191014', 'all' );
	wp_deregister_script( 'l10n' );
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js', array(), '20191014', false);
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'bootstrap', 'https://cdn.bootcss.com/twitter-bootstrap/4.3.1/js/bootstrap.min.js', array(), '20191014', false );
	wp_enqueue_style('bootstrap', 'https://cdn.bootcss.com/twitter-bootstrap/4.3.1/css/bootstrap.min.css', array(), '20191014', 'all');
	wp_enqueue_script( 'hjyl', get_theme_file_uri( '/js/hjyl.js' ), array(), '20191014', true );
	if ( ! has_custom_logo() ) {
		wp_enqueue_script( 'hjyl_logo', get_theme_file_uri( '/js/logo.js' ), array(), '20191014', true );
	}
	if( is_page('archives') ){
		wp_enqueue_script( 'archives', get_template_directory_uri() . '/js/archives.js', array(), '20191014', false);
		wp_enqueue_style( 'archives', get_template_directory_uri() . '/css/archives.css', array(), '20191014', 'screen');
	};
	if ( is_singular() ) {
	wp_enqueue_script( 'jquery-qrcode', 'https://cdn.bootcss.com/jquery.qrcode/1.0/jquery.qrcode.min.js', array(), '20191014', true);
	wp_enqueue_script( 'qrcode-js', get_theme_file_uri('/js/qrcode.js'), array('jquery'), '20191014', true);
	wp_enqueue_script( 'lightbox-js', 'https://cdn.bootcss.com/lightbox2/2.11.1/js/lightbox.min.js', array('jquery'), '20191014', true);
	wp_enqueue_style('lightbox', 'https://cdn.bootcss.com/lightbox2/2.11.1/css/lightbox.min.css', array(), '20191014', 'all');
	}
	if ( is_singular() && comments_open() ) {
	wp_enqueue_script( 'comment-reply' );
	wp_enqueue_script( 'ajax-comment', get_theme_file_uri('/js/comments-ajax.js'), array('jquery'), '20191014', true);
	}
	wp_localize_script( 'ajax-comment', 'ajaxcomment', array(
		'ajax_url' => admin_url('admin-ajax.php'),
		'order' => get_option('comment_order'),
		'formpostion' => 'bottom', //默认为bottom，如果你的表单在顶部则设置为top。
		'txt1' => __('Wait a moment...','HJYL_HILAU'),
		'txt2' => __('Good Comment','HJYL_HILAU'),
	) );
}
add_action( 'wp_enqueue_scripts', 'hjyl_script' );

	//分页导航	
function par_pagenavi($range = 9){
	global $paged, $wp_query;
	$max_page = $wp_query->max_num_pages;
	if($max_page > 1){if(!$paged){$paged = 1;}
	if($paged != 1){echo "<a href='" . get_pagenum_link(1) . "' class='extend' title='".__('To first page', 'HJYL_HILAU')."'>".hjyl_get_svg( array( 'icon' => 'arrow-dleft' ) )."</a>";}
	previous_posts_link(hjyl_get_svg( array( 'icon' => 'arrow-left' ) ));
    if($max_page > $range){
		if($paged < $range){for($i = 1; $i <= ($range + 1); $i++){echo "<a href='" . get_pagenum_link($i) ."'";
		if($i==$paged)echo " class='current'";echo ">$i</a>";}}
    elseif($paged >= ($max_page - ceil(($range/2)))){
		for($i = $max_page - $range; $i <= $max_page; $i++){echo "<a href='" . get_pagenum_link($i) ."'";
		if($i==$paged)echo " class='current'";echo ">$i</a>";}}
	elseif($paged >= $range && $paged < ($max_page - ceil(($range/2)))){
		for($i = ($paged - ceil($range/2)); $i <= ($paged + ceil(($range/2))); $i++){echo "<a href='" . get_pagenum_link($i) ."'";if($i==$paged) echo " class='current'";echo ">$i</a>";}}}
    else{for($i = 1; $i <= $max_page; $i++){echo "<a href='" . get_pagenum_link($i) ."'";
    if($i==$paged)echo " class='current'";echo ">$i</a>";}}
	next_posts_link(hjyl_get_svg( array( 'icon' => 'arrow-right' ) ));
    if($paged != $max_page){echo "<a href='" . get_pagenum_link($max_page) . "' class='extend' title='".__('To last page', 'HJYL_HILAU')."'>".hjyl_get_svg( array( 'icon' => 'arrow-dright' ) )."</a>";}}
}

// 文末版权声明
function hjyl_content_copyright($content)
{
  if (is_singular() || is_feed()) {
    $content .=
      '<div id="content-copyright"><span style="font-weight:bold;text-shadow:0 1px 0 #ddd;font-size: 13px;">声明：</span><span style="font-size: 13px;">本文采用 <a rel="nofollow" href="http://creativecommons.org/licenses/by-nc-sa/3.0/" title="署名-非商业性使用-相同方式共享">BY-NC-SA</a> 协议进行授权，如无注明均为原创，转载请注明转自 <a href="' .
      home_url() .
      '">' .
      get_bloginfo('name') .
      '</a><br>本文地址：<a rel="bookmark" title="' .
      get_the_title() .
      '" href="' .
      get_permalink() .
      '">' .
      get_the_title() .
      '</a></span></div>';
  }
  return $content;
}
add_filter('the_content', 'hjyl_content_copyright');

/* 最新回复 */
function new_comment_posts($no_posts = 10, $before = '<li>', $after = '</li>', $show_pass_post = false, $duration='') {
global $wpdb;
$request = "SELECT ID, post_title, COUNT($wpdb->comments.comment_post_ID) AS 'comment_count' FROM $wpdb->posts, $wpdb->comments";
$request .= " WHERE comment_approved = '1' AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status = 'publish'";
if(!$show_pass_post) $request .= " AND post_password =''";
if($duration !="") { $request .= " AND DATE_SUB(CURDATE(),INTERVAL ".$duration." DAY) < post_date ";
}
$request .= " GROUP BY $wpdb->comments.comment_post_ID ORDER BY comment_date_gmt DESC LIMIT $no_posts";
$posts = $wpdb->get_results($request);
$output = '';
if ($posts) {
foreach ($posts as $post) {
$post_tt = stripslashes($post->post_title);
if("" == $post_tt){
	$post_title = sprintf(__('Untitled #%s', 'HJYL_HILAU'),get_the_date('Y-m-d'));
}else{
	$post_title = wp_trim_words($post_tt,18);
}
$comment_count = $post->comment_count;
$permalink = get_permalink($post->ID);
$output .= $before . '<a href="' . $permalink . '" title="' . $post_tt.'">' . $post_title . '</a><span class="list_comm">'. $comment_count .'°</span> ' . $after;
}
} else {
$output .= $before . "None found" . $after;
}
echo $output;
}

//缩略图 开始//
function post_thumbnail($width=0, $height=0){
    global $post, $posts;
	$first_img ='';
	$pc = $post->post_content;    
	$sp = '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i'; 
	preg_match_all( $sp, $pc, $aPics );   
	$np = count($aPics[0]);  
	if ( $np > 0 ) { 
		echo '<img src="'.$aPics[1][0].'" alt="'.get_the_title().'" width="'.$width.'" height="'.$height.'"/>';      
	}; 
}

//时间显示方式‘xx以前’
function time_ago($type = 'comment', $day = 365) {
    $d = $type == 'post' ? 'get_post_time' : 'get_comment_time';
    //if (time() - $d('U') > 60 * 60 * 24 * $day) return;
	echo sprintf(__('%s ago','HJYL_HILAU'), human_time_diff($d('U') , strtotime(current_time('mysql', 0))));
}
function timeago($ptime) {
    $ptime = strtotime($ptime);
    $etime = time() - $ptime;
    if ($etime < 1) return __('Just Now','HJYL_HILAU');
    $interval = array(
        12 * 30 * 24 * 60 * 60 => __(' years ago', 'HJYL_HILAU'),
        30 * 24 * 60 * 60 => __(' month ago', 'HJYL_HILAU'),
        7 * 24 * 60 * 60 => __(' weeks ago', 'HJYL_HILAU'),
        24 * 60 * 60 => __(' days ago', 'HJYL_HILAU'),
        60 * 60 => __(' hours ago', 'HJYL_HILAU'),
        60 => __(' minutes ago', 'HJYL_HILAU'),
        1 => __(' seconds ago', 'HJYL_HILAU')
    );
    foreach ($interval as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . $str;
        }
    };
}

/**
 * Returns true if comment is by author of the post.
 *
 * @see get_comment_class()
 */
function is_comment_by_post_author( $comment = null ) {
	if ( is_object( $comment ) && $comment->user_id > 0 ) {
		$user = get_userdata( $comment->user_id );
		$post = get_post( $comment->comment_post_ID );
		if ( ! empty( $user ) && ! empty( $post ) ) {
			return $comment->user_id === $post->post_author;
		}
	}
	return false;
}

//调整评论表单顺序
function move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}
add_filter( 'comment_form_fields', 'move_comment_field_to_bottom' );

/**
* WordPress外链新窗口打开并使用php页面go跳转
* https://zhang.ge/5086.html
* 先添加go调整页面并应该go跳转页面模版
* 伪静态设置：rewrite ^/go/([^\?]+)$ /go/?url=$1 last;
*/
function the_content_nofollow($content){
	preg_match_all('/<a(.*?)href="(.*?)"(.*?)>/',$content,$matches);
	if($matches){
		foreach($matches[2] as $val){
			if(strpos($val,'://')!==false && strpos($val,home_url())===false && !preg_match('/\.(jpg|jepg|png|ico|bmp|gif|tiff)/i',$val)){
				$content=str_replace("href=\"$val\"", "href=\"".home_url()."/go/?url=".base64_encode($val)."\" rel=\"nofollow\"",$content);  //非伪静态设置
				//$content=str_replace("href=\"$val\"", "href=\"".home_url()."/go/".base64_encode($val)."\" rel=\"nofollow\"",$content);   //伪静态设置 暂时无效
			}
		}
	}
return $content;
}
add_filter('the_content','the_content_nofollow',999);
add_filter('comment_text', 'the_content_nofollow', 99);
add_filter('get_comment_author_link', 'the_content_nofollow', 5);

//下载单页短代码
function page_download($atts, $content = null) {
	//return '<a class="noexternal" href="'.home_url().'/download/?pid='.get_the_ID().'" target="_blank" rel="nofollow"><button type="button" class="btn btn-outline-danger">'.hjyl_get_svg( array( 'icon' => 'download' ) ).' 点击下载</button></a>';   //非伪静态设置
	return '<a class="noexternal" href="'.home_url().'/download/'.get_the_ID().'/" target="_blank" rel="nofollow"><button type="button" class="btn btn-outline-danger">'.hjyl_get_svg( array( 'icon' => 'download' ) ).' 点击下载</button></a>';   //伪静态设置
}
add_shortcode('pdownload', 'page_download');

//快捷输入[Prism]标签
function hjyl_highlight_quicktags() { 
if (wp_script_is('quicktags')){
?>
<script type="text/javascript">
QTags.addButton( 'post_h3', '<h3>', '\n<h3>', '</h3>\n' ); //快捷输入<h3>标签
QTags.addButton( 'post_hr', '<hr>', '\n<hr />\n' ); //快捷输入<hr>标签
QTags.addButton( 'highlight_php', '[php]', '\n[php]\n', '[/php]\n' ); //快捷输入[php]标签
QTags.addButton( 'highlight_css', '[css]', '\n[css]\n', '[/css]\n' ); //快捷输入[css]标签
QTags.addButton( 'highlight_js', '[js]', '\n[js]\n', '[/js]\n' ); //快捷输入[js]标签
QTags.addButton( 'highlight_xml', '[xml]', '\n[xml]\n', '[/xml]\n' ); //快捷输入[xml]标签
QTags.addButton( 'highlight_code', '[code]', '\n[code]\n', '[/code]\n' ); //快捷输入[code]标签
QTags.addButton( 'hy_download', '下载按钮', '[pdownload]', '' ); //添加下载按钮
</script>
<?php }}
add_action('after_wp_tiny_mce', 'hjyl_highlight_quicktags' );

//显示数据库查询次数、查询时间及内存占用的代码
function iperformance($visible = false){
    $stat = sprintf('%d 次查询 用时 %.3f 秒, 耗费了 %.2fMB 内存', get_num_queries(), timer_stop(0, 3), memory_get_peak_usage() / 1024 / 1024);
    echo $visible ? $stat : "<!-- {$stat} -->";
}
add_action('wp_footer', 'iperformance', 20);

require( get_template_directory() . '/inc/functions-comment.php' );
require( get_template_directory() . '/inc/functions-tougao.php' );
require( get_template_directory() . '/inc/functions-customizer.php' );
// Custom Category control 
require( get_template_directory() . '/inc/category-dropdown-custom-control.php');
require( get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php');
require( get_template_directory() . '/inc/functions-weixin-push.php');
require( get_template_directory() . '/inc/functions-svg.php');
require( get_template_directory() . '/inc/class-metabox.php');
require( get_template_directory() . '/inc/functions-widgets.php');

