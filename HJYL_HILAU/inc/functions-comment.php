<?php
define('AC_VERSION','2.0.0');

if ( version_compare( $GLOBALS['wp_version'], '5.0', '<' ) ) {
	wp_die('请升级到5.0以上版本');
}

/* comment_mail_notify v1.0 by willin kan.  */
function comment_mail_notify($comment_id) {
  $admin_notify = '1'; // admin notice ( '1'=ture ; '0'=false )
  $admin_email = get_bloginfo ('admin_email'); // $admin_email or your own e-mail.
  $comment = get_comment($comment_id);
  $comment_author_email = trim($comment->comment_author_email);
  $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
	if(""!==get_the_title($comment->comment_post_ID) ) {
		$comment_title = sprintf(__('replied you at [ %s ] as followed:','HJYL_HILAU'), get_the_title($comment->comment_post_ID));
	}else{
		$comment_title = sprintf(__('replied you at [ Untitled #%s ] as followed:', 'HJYL_HILAU'),get_the_date('Y-m-d', $comment->comment_post_ID));
	}
  global $wpdb;
  if ($wpdb->query("Describe {$wpdb->comments} comment_mail_notify") == '')
    $wpdb->query("ALTER TABLE {$wpdb->comments} ADD COLUMN comment_mail_notify TINYINT NOT NULL DEFAULT 0;");
  if (($comment_author_email != $admin_email && isset($_POST['comment_mail_notify'])) || ($comment_author_email == $admin_email && $admin_notify == '1'))
    $wpdb->query("UPDATE {$wpdb->comments} SET comment_mail_notify='1' WHERE comment_ID='$comment_id'");
  $notify = $parent_id ? get_comment($parent_id)->comment_mail_notify : '0';
  $spam_confirmed = $comment->comment_approved;
  if ($parent_id != '' && $spam_confirmed != 'spam' && $notify == '1') {
    $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])); // e-mail from someone, no-reply can be you own.
    $to = trim(get_comment($parent_id)->comment_author_email);
    $subject = sprintf(__('You have a message from %s','HJYL_HILAU'), get_option('blogname'));
    $message = '
    <div style="color:#111;margin:10px auto;width:420px;font-size: 16px;">
		<h1 style="text-align:center;font-size:48px;">' . get_option('blogname') . '</h1>
		<p>' . trim(get_comment($parent_id)->comment_author) . ', '.__('Hello!','HJYL_HILAU').'</p>
		<div style="margin:20px 0;">
			<span style="float:left;padding:5px;border:1px solid #EEEEEE;border-radius:5px;margin-right:10px;">'.get_avatar($comment_author_email,48).'</span>
			' . trim($comment->comment_author) . $comment_title.'<br />'
			. trim($comment->comment_content) . '<br />
		</div>
      <p><a style="background:#333436;padding:5px 10px;border-radius:5px;color:#ddd;text-decoration:none;" href="' . htmlspecialchars(get_comment_link($parent_id)) . '">'.__('Read more','HJYL_HILAU').'</a></p>
    </div>
	<div style="font-size:11px;text-align:center;">
		<p>'.__('The mail automatically by system, Do not Reply.','HJYL_HILAU').'</p>
		<p>By <a href="' . home_url() . '">' . get_option('blogname') . '</a></p>
	</div>';
    $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
    $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
    wp_mail( $to, $subject, $message, $headers );
    //echo 'mail to ', $to, '<br/> ' , $subject, $message; // for testing
  }
}
add_action('comment_post', 'comment_mail_notify');
/* default: true */
function add_checkbox() {
  echo '<input type="checkbox" name="comment_mail_notify" id="comment_mail_notify" value="comment_mail_notify" checked="checked" style="margin:10px 0;" /><label for="comment_mail_notify">'.__('Email me if replied','HJYL_HILAU').'</label>';
}
add_action('comment_form', 'add_checkbox');
// -- END ----------------------------------------

//comment
if ( ! function_exists( 'comment' ) ) :
function hjyl_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	global $commentcount;
	if(!$commentcount) { 
		$page = ( get_query_var('cpage') ) ? get_query_var('cpage') : get_page_of_comment( $comment->comment_ID, $args );
		$cpp=get_option('comments_per_page');
		$commentcount = $cpp * ($page - 1);
	}
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<span class="floor">
			<?php if (!empty(get_option('thread_comments'))) { ?>
				<?php if(!$parent_id = $comment->comment_parent) {printf('#%s', ++$commentcount);} ?>
			<?php }else{ ?>
				<?php printf('#%s', ++$commentcount); ?>
			<?php } ?>
		</span>
		<div id="comment-<?php comment_ID(); ?>" class="comment">
		<div class="comment-author vcard">
			<?php
			$default= ''; echo get_avatar( $comment, 96, $default, $comment->comment_author );
			if ( is_comment_by_post_author( $comment ) ) {
				printf( '<span class="post-author-badge" aria-hidden="true"><i class="fas fa-hospital-symbol"></i></span>' );
			}
			?>
			<div class="comment_meta">
				<h4><?php printf( '<cite class="fn"> %s </cite>', get_comment_author_link() ); ?></h4>
				<a class="comment_time" href="#comment-<?php comment_ID() ?>" title="<?php printf( '%s', comment_date('Y/m/d '),  comment_time()); ?>"><?php printf(__('%s','HJYL_HILAU'), time_ago()); ?></a>
				<?php if(function_exists('wpua_custom_output')) {wpua_custom_output();} //UA ICON ?>
			<span class="reply">
				<?php if ($depth == get_option('thread_comments_depth')) : ?>
					 <a onclick="return addComment.moveForm( 'comment-<?php comment_ID() ?>','<?php echo $comment->comment_parent; ?>', 'respond','<?php echo $comment->comment_post_ID; ?>' )" href="?replytocom=<?php comment_ID() ?>#respond" class="comment-reply-link" rel="nofollow">-@</a>
				 <?php else: ?>
					 <a onclick="return addComment.moveForm( 'comment-<?php comment_ID() ?>','<?php comment_ID() ?>', 'respond','<?php echo $comment->comment_post_ID; ?>' ) " href="?replytocom=<?php comment_ID() ?>#respond" class="comment-reply-link" rel="nofollow">-@</a>
				 <?php endif; ?>
			</span><!-- .reply -->
			</div>
		</div><!-- .comment-author .vcard -->
			<div class="comment-body"><?php comment_text(); ?></div>


		</div><!-- #comment-##  -->

<?php break;endswitch;}endif;
//pingback and trackback
function hjyl_pings($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    if('pingback' == get_comment_type()) $pingtype = 'Pingback';
    else $pingtype = 'Trackback';
?>
    <li id="comment-<?php echo $comment->comment_ID ?>">
        [<?php echo $pingtype; ?>] <?php comment_author_link(); ?>
		<span class="ping_time"><?php echo mysql2date('Y.m.d', $comment->comment_date); ?></span>
<?php }

// WordPress AJAX Comments
if(!function_exists('fa_ajax_comment_err')) :

    function fa_ajax_comment_err($a) {
        header('HTTP/1.0 500 Internal Server Error');
        header('Content-Type: text/plain;charset=UTF-8');
        echo $a;
        exit;
    }

endif;

if(!function_exists('fa_ajax_comment_callback')) :

    function fa_ajax_comment_callback(){
        $comment = wp_handle_comment_submission( wp_unslash( $_POST ) );
        if ( is_wp_error( $comment ) ) {
            $data = $comment->get_error_data();
            if ( ! empty( $data ) ) {
            	fa_ajax_comment_err($comment->get_error_message());
            } else {
                exit;
            }
        }
        $user = wp_get_current_user();
        do_action('set_comment_cookies', $comment, $user);
        $GLOBALS['comment'] = $comment; //根据你的评论结构自行修改，如使用默认主题则无需修改
        ?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<div id="comment-<?php comment_ID(); ?>"  class="comment">
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'HJYL_HILAU' ); ?></em><br />
				<?php endif; ?>
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment,$size='96',$comment->comment_author); ?>
				<div class="comment-meta">
					<h4><?php printf( __( '%s', 'HJYL_HILAU'), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?></h4>
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" title="<?php printf( __( '%1$s at %2$s', 'HJYL_HILAU' ), get_comment_date(),  get_comment_time() ); ?>"><?php printf(__('%s','HJYL_HILAU'), time_ago()); ?></a>
				</div>
				</div>
				<div class="comment-body"><?php comment_text(); ?></div>
			</div>
        </li>
        <?php die();
    }

endif;

add_action('wp_ajax_nopriv_ajax_comment', 'fa_ajax_comment_callback');
add_action('wp_ajax_ajax_comment', 'fa_ajax_comment_callback');
?>